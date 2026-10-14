<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderItemController extends Controller
{
    /** Add a product to an existing order. */
    public function store(Request $request, Order $order)
    {
        if (! $order->isEditable()) {
            return back()->with('error', 'Items can only be changed while the order is pending or preparing.');
        }

        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        DB::transaction(function () use ($order, $data) {
            $product = Product::lockForUpdate()->findOrFail($data['product_id']);

            if (! $product->is_available) {
                throw ValidationException::withMessages(['product_id' => "{$product->name} is currently unavailable."]);
            }

            if ($product->stock < $data['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => "Not enough stock for {$product->name} (only {$product->stock} left).",
                ]);
            }

            $item = $order->items()->where('product_id', $product->id)->first();

            if ($item) {
                // Same product already on the order: just increase the quantity.
                $quantity = $item->quantity + $data['quantity'];
                $item->update(['quantity' => $quantity, 'subtotal' => $item->unit_price * $quantity]);
            } else {
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $data['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $product->price * $data['quantity'],
                ]);
            }

            $product->decrement('stock', $data['quantity']);
            $order->recalculateTotal();
        });

        return back()->with('success', 'Item added to the order.');
    }

    /** Change the quantity of an order line. */
    public function update(Request $request, Order $order, OrderItem $item)
    {
        abort_unless($item->order_id === $order->id, 404);

        if (! $order->isEditable()) {
            return back()->with('error', 'Items can only be changed while the order is pending or preparing.');
        }

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        DB::transaction(function () use ($order, $item, $data) {
            $product = Product::lockForUpdate()->findOrFail($item->product_id);
            $difference = $data['quantity'] - $item->quantity;

            if ($difference > 0 && $product->stock < $difference) {
                throw ValidationException::withMessages([
                    'quantity' => "Not enough stock for {$product->name} (only {$product->stock} more available).",
                ]);
            }

            // Positive difference takes stock, negative difference returns it.
            $product->update(['stock' => $product->stock - $difference]);
            $item->update([
                'quantity' => $data['quantity'],
                'subtotal' => $item->unit_price * $data['quantity'],
            ]);
            $order->recalculateTotal();
        });

        return back()->with('success', 'Item quantity updated.');
    }

    /** Remove a line from the order. */
    public function destroy(Order $order, OrderItem $item)
    {
        abort_unless($item->order_id === $order->id, 404);

        if (! $order->isEditable()) {
            return back()->with('error', 'Items can only be changed while the order is pending or preparing.');
        }

        if ($order->items()->count() <= 1) {
            return back()->with('error', 'An order must keep at least one item. Delete or cancel the order instead.');
        }

        DB::transaction(function () use ($order, $item) {
            $item->product->increment('stock', $item->quantity);
            $item->delete();
            $order->recalculateTotal();
        });

        return back()->with('success', 'Item removed from the order.');
    }
}