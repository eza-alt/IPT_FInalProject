@extends('layouts.app')

@section('title', $supplier->name)

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h1 class="h3 mb-0">{{ $supplier->name }}</h1>
    <div>
        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Contact person</dt><dd class="col-sm-9">{{ $supplier->contact_person ?: '-' }}</dd>
            <dt class="col-sm-3">Phone</dt><dd class="col-sm-9">{{ $supplier->phone ?: '-' }}</dd>
            <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $supplier->email ?: '-' }}</dd>
            <dt class="col-sm-3">Address</dt><dd class="col-sm-9 mb-0">{{ $supplier->address ?: '-' }}</dd>
        </dl>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><strong>Products supplied ({{ $products->count() }})</strong></div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Product</th><th>Category</th><th>Price</th><th>Stock</th></tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
                        <td>{{ $product->category->name }}</td>
                        <td>&#8369;{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">This supplier has no products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection