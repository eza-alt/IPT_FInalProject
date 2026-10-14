@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1 class="h3 mb-4">Dashboard</h1>

<div class="row g-3 mb-4">
    @php
        $cards = [
            ['Orders', $orderCount, 'bi-receipt', 'primary', route('orders.index')],
            ['Products', $productCount, 'bi-box-seam', 'success', route('products.index')],
            ['Categories', $categoryCount, 'bi-tags', 'warning', route('categories.index')],
            ['Suppliers', $supplierCount, 'bi-truck', 'info', route('suppliers.index')],
        ];
    @endphp
    @foreach ($cards as [$label, $count, $icon, $color, $link])
        <div class="col-6 col-lg-3">
            <a href="{{ $link }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="fs-1 text-{{ $color }} me-3"><i class="bi {{ $icon }}"></i></div>
                        <div>
                            <div class="text-muted small">{{ $label }}</div>
                            <div class="fs-3 fw-semibold text-dark">{{ $count }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Revenue (completed orders)</div>
                <div class="fs-2 fw-semibold text-success">&#8369;{{ number_format($revenue, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small mb-2">Orders by status</div>
                @foreach (\App\Models\Order::STATUSES as $status)
                    <a href="{{ route('orders.index', ['status' => $status]) }}"
                       class="badge rounded-pill fs-6 me-2 text-decoration-none {{ (new \App\Models\Order(['status' => $status]))->statusBadgeClass() }}">
                        {{ ucfirst($status) }}: {{ $statusCounts[$status] ?? 0 }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong>Recent orders</strong>
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-secondary">View all</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr><th>#</th><th>Customer</th><th>Items</th><th>Total</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($recentOrders as $order)
                            <tr>
                                <td><a href="{{ route('orders.show', $order) }}">#{{ $order->id }}</a></td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->items_count }}</td>
                                <td>&#8369;{{ number_format($order->total_amount, 2) }}</td>
                                <td><span class="badge {{ $order->statusBadgeClass() }}">{{ ucfirst($order->status) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <strong>Low stock</strong>
                <span class="text-muted small">(&le; {{ \App\Models\Product::LOW_STOCK_LEVEL }} left)</span>
            </div>
            <ul class="list-group list-group-flush">
                @forelse ($lowStock as $product)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                        <span class="badge {{ $product->stock === 0 ? 'bg-danger' : 'bg-warning text-dark' }}">
                            {{ $product->stock }} left
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">All products are well stocked.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection