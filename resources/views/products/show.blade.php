@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h1 class="h3 mb-0">{{ $product->name }}</h1>
    <div>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Category</dt>
            <dd class="col-sm-9"><a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a></dd>

            <dt class="col-sm-3">Supplier</dt>
            <dd class="col-sm-9"><a href="{{ route('suppliers.show', $product->supplier) }}">{{ $product->supplier->name }}</a></dd>

            <dt class="col-sm-3">Price</dt>
            <dd class="col-sm-9">&#8369;{{ number_format($product->price, 2) }}</dd>

            <dt class="col-sm-3">Stock</dt>
            <dd class="col-sm-9">{{ $product->stock }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">{{ $product->is_available ? 'Available' : 'Unavailable' }}</dd>

            <dt class="col-sm-3">Total units ordered</dt>
            <dd class="col-sm-9">{{ $timesOrdered }}</dd>

            <dt class="col-sm-3">Description</dt>
            <dd class="col-sm-9 mb-0">{{ $product->description ?: '-' }}</dd>
        </dl>
    </div>
</div>
@endsection