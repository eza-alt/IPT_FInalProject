@extends('layouts.app')

@section('title', 'Edit Order #' . $order->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>Edit Order #{{ $order->id }}</strong></div>
            <div class="card-body">
                <p class="text-muted small">To change the products in this order, open the order details page.</p>
                <form action="{{ route('orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Customer name <span class="text-danger">*</span></label>
                        <input type="text" id="customer_name" name="customer_name" maxlength="100"
                               class="form-control @error('customer_name') is-invalid @enderror"
                               value="{{ old('customer_name', $order->customer_name) }}" required>
                        @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="order_date" class="form-label">Order date <span class="text-danger">*</span></label>
                            <input type="date" id="order_date" name="order_date"
                                   class="form-control @error('order_date') is-invalid @enderror"
                                   value="{{ old('order_date', $order->order_date->toDateString()) }}" required>
                            @error('order_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                                @foreach (\App\Models\Order::STATUSES as $status)
                                    <option value="{{ $status }}" @selected(old('status', $order->status) === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea id="notes" name="notes" rows="3" maxlength="500"
                                  class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $order->notes) }}</textarea>
                        @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Save</button>
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection