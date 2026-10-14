@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h1 class="h3 mb-0">Orders</h1>
    <a href="{{ route('orders.create') }}" class="btn btn-success"><i class="bi bi-plus-circle"></i> New Order</a>
</div>

<form method="GET" action="{{ route('orders.index') }}" class="row g-2 mb-3">
    <div class="col-sm-6 col-md-4">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search by customer name...">
    </div>
    <div class="col-sm-6 col-md-3">
        <select name="status" class="form-select">
            <option value="">All statuses</option>
            @foreach (\App\Models\Order::STATUSES as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-secondary"><i class="bi bi-funnel"></i> Filter</button>
        @if (request('q') || request('status'))
            <a href="{{ route('orders.index') }}" class="btn btn-link">Clear</a>
        @endif
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Customer</th><th>Date</th><th class="text-center">Items</th><th>Total</th><th>Status</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td class="fw-semibold">{{ $order->customer_name }}</td>
                        <td>{{ $order->order_date->format('M d, Y') }}</td>
                        <td class="text-center">{{ $order->items_count }}</td>
                        <td>&#8369;{{ number_format($order->total_amount, 2) }}</td>
                        <td><span class="badge {{ $order->statusBadgeClass() }}">{{ ucfirst($order->status) }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete order #{{ $order->id }}? Reserved stock will be returned.');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection