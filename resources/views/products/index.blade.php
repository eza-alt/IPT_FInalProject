@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h1 class="h3 mb-0">Products</h1>
    <a href="{{ route('products.create') }}" class="btn btn-success"><i class="bi bi-plus-circle"></i> Add Product</a>
</div>

<form method="GET" action="{{ route('products.index') }}" class="row g-2 mb-3">
    <div class="col-sm-6 col-md-4">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search products...">
    </div>
    <div class="col-sm-6 col-md-3">
        <select name="category_id" class="form-select">
            <option value="">All categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-secondary"><i class="bi bi-funnel"></i> Filter</button>
        @if (request('q') || request('category_id'))
            <a href="{{ route('products.index') }}" class="btn btn-link">Clear</a>
        @endif
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Product</th><th>Category</th><th>Supplier</th><th>Price</th><th>Stock</th><th>Status</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td class="fw-semibold">{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->supplier->name }}</td>
                        <td>&#8369;{{ number_format($product->price, 2) }}</td>
                        <td>
                            <span class="badge {{ $product->stock <= \App\Models\Product::LOW_STOCK_LEVEL ? 'bg-danger' : 'bg-success' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            @if ($product->is_available)
                                <span class="badge bg-success-subtle text-success-emphasis">Available</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary-emphasis">Unavailable</span>
                            @endif
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete product {{ addslashes($product->name) }}?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $products->links() }}</div>
@endsection