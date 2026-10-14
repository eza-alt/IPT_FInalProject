<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'supplier'])
            ->when($request->q, fn ($query, $q) => $query->where('name', 'like', "%{$q}%"))
            ->when($request->category_id, fn ($query, $id) => $query->where('category_id', $id))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        return view('products.create', $this->formData());
    }

    public function store(Request $request)
    {
        Product::create($this->validated($request));

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'supplier']);
        $timesOrdered = $product->orderItems()->sum('quantity');

        return view('products.show', compact('product', 'timesOrdered'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', array_merge($this->formData(), ['product' => $product]));
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validated($request, $product));

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Data integrity: keep order history intact.
        if ($product->orderItems()->exists()) {
            return back()->with('error', 'Cannot delete this product because it appears in existing orders. You can mark it as unavailable instead.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    // Data needed by the dropdowns in the form.
    private function formData(): array
    {
        return [
            'categories' => Category::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ];
    }

    private function validated(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
            'name' => ['required', 'string', 'max:100', Rule::unique('products', 'name')->ignore($product?->id)],
            'description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0.01', 'max:99999.99'],
            'stock' => ['required', 'integer', 'min:0', 'max:100000'],
        ]);

        $data['is_available'] = $request->boolean('is_available');

        return $data;
    }
}