@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h1 class="h3 mb-0">{{ $category->name }}</h1>
    <div>
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<p class="text-muted">{{ $category->description ?: 'No description.' }}</p>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><strong>Products in this category ({{ $products->count() }})</strong></div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Product</th><th>Supplier</th><th>Price</th><th>Stock</th></tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
                        <td>{{ $product->supplier->name }}</td>
                        <td>&#8369;{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection