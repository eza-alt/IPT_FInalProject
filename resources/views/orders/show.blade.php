@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h1 class="h3 mb-0">
        Order #{{ $order->id }}
        <span class="badge fs-6 align-middle {{ $order->statusBadgeClass() }}">{{ ucfirst($order->status) }}</span>
    </h1>
    <div>
        <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Customer</dt><dd class="col-sm-9">{{ $order->customer_name }}</dd>
            <dt class="col-sm-3">Order date</dt><dd class="col-sm-9">{{ $order->order_date->format('F d, Y') }}</dd>
            <dt class="col-sm-3">Notes</dt><dd class="col-sm-9 mb-0">{{ $order->notes ?: '-' }}</dd>
        </dl>
    </div>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white"><strong>Items</strong></div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr><th>Product</th><th>Unit price</th><th style="width: 190px;">Quantity</th><th>Subtotal</th><th class="text-end">Remove</th></tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td><a href="{{ route('products.show', $item->product) }}">{{ $item->product->name }}</a></td>
                        <td>&#8369;{{ number_format($item->unit_price, 2) }}</td>
                        <td>
                            @if ($order->isEditable())
                                <form action="{{ route('orders.items.update', [$order, $item]) }}" method="POST" class="input-group input-group-sm">
                                    @csrf @method('PUT')
                                    <input type="number" min="1" max="100" name="quantity" value="{{ $item->quantity }}" class="form-control" required>
                                    <button class="btn btn-outline-primary" title="Update quantity"><i class="bi bi-check-lg"></i></button>
                                </form>
                            @else
                                {{ $item->quantity }}
                            @endif
                        </td>
                        <td>&#8369;{{ number_format($item->subtotal, 2) }}</td>
                        <td class="text-end">
                            @if ($order->isEditable())
                                <form action="{{ route('orders.items.destroy', [$order, $item]) }}" method="POST"
                                      onsubmit="return confirm('Remove {{ addslashes($item->product->name) }} from this order?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <th colspan="3" class="text-end">Total</th>
                    <th colspan="2" class="fs-5">&#8369;{{ number_format($order->total_amount, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@if ($order->isEditable())
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white"><strong>Add a product to this order</strong></div>
        <div class="card-body">
            <form action="{{ route('orders.items.store', $order) }}" method="POST" class="row g-2">
                @csrf
                <div class="col-md-7">
                    <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                        <option value="">-- Select product --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                {{ $product->name }} - &#8369;{{ number_format($product->price, 2) }} ({{ $product->stock }} in stock)
                            </option>
                        @endforeach
                    </select>
                    @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-6 col-md-2">
                    <input type="number" min="1" max="100" name="quantity" value="{{ old('quantity', 1) }}"
                           class="form-control @error('quantity') is-invalid @enderror" required>
                    @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-6 col-md-3">
                    <button class="btn btn-success w-100"><i class="bi bi-plus-circle"></i> Add item</button>
                </div>
            </form>
        </div>
    </div>
@else
    <div class="alert alert-secondary mb-0">
        Items can only be changed while an order is <strong>pending</strong> or <strong>preparing</strong>.
    </div>
@endif
@endsection