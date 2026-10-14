<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::withCount('items')
            ->when($request->q, fn ($query, $q) => $query->where('customer_name', 'like', "%{$q}%"))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest('order_date')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create', [
            'products' => Product::where('is_available', true)->where('stock', '>', 0)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'order_date' => ['required', 'date'],
            'status' => ['required', Rule::in(['pending', 'preparing'])],
            'notes' => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id', 'distinct'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:100'],
        ], [
            'items.required' => 'Add at least one product to the order.',
            'items.*.product_id.required' => 'Please choose a product for every order line.',
            'items.*.product_id.distinct' => 'The same product is listed more than once. Combine it into one line.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
        ]);

        $order = DB::transaction(function () use ($data) {
            $order = Order::create([
                'customer_name' => $data['customer_name'],
                'order_date' => $data['order_date'],
                'status' => $data['status'],
                'notes' => $data['notes'] ?? null,
                'total_amount' => 0,
            ]);

            foreach ($data['items'] as $index => $line) {
                $product = Product::lockForUpdate()->findOrFail($line['product_id']);

                if (! $product->is_available) {
                    throw ValidationException::withMessages([
                        "items.$index.product_id" => "{$product->name} is currently unavailable.",
                    ]);
                }

                if ($product->stock < $line['quantity']) {
                    throw ValidationException::withMessages([
                        "items.$index.quantity" => "Not enough stock for {$product->name} (only {$product->stock} left).",
                    ]);
                }

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $line['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $product->price * $line['quantity'],
                ]);

                $product->decrement('stock', $line['quantity']);
            }

            $order->recalculateTotal();

            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully.');
    }

    public function show(Order $order)
    {
        $order->load('items.product');

        $products = Product::where('is_available', true)
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('orders.show', compact('order', 'products'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'order_date' => ['required', 'date'],
            'status' => ['required', Rule::in(Order::STATUSES)],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        if ($order->status === 'cancelled' && $data['status'] !== 'cancelled') {
            return back()->withInput()->withErrors([
                'status' => 'A cancelled order cannot be reopened. Please create a new order instead.',
            ]);
        }

        DB::transaction(function () use ($order, $data) {
            // Cancelling an order puts its items back into stock.
            if ($order->status !== 'cancelled' && $data['status'] === 'cancelled') {
                $this->restoreStock($order);
            }

            $order->update($data);
        });

        return redirect()->route('orders.show', $order)->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {
            if ($order->status !== 'cancelled') {
                $this->restoreStock($order);
            }

            $order->delete(); // order_items are removed by the cascading foreign key
        });

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }

    private function restoreStock(Order $order): void
    {
        foreach ($order->items()->with('product')->get() as $item) {
            $item->product->increment('stock', $item->quantity);
        }
    }
}