@extends('layouts.app')

@section('title', 'New Order')

@section('content')
@php
    // Keep the lines the user typed if validation fails; otherwise start with one empty line.
    $lines = old('items', [['product_id' => '', 'quantity' => 1]]);
    $nextIndex = collect($lines)->keys()->max() + 1;
@endphp

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>New Order</strong></div>
            <div class="card-body">
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="customer_name" class="form-label">Customer name <span class="text-danger">*</span></label>
                            <input type="text" id="customer_name" name="customer_name" maxlength="100"
                                   class="form-control @error('customer_name') is-invalid @enderror"
                                   value="{{ old('customer_name') }}" required>
                            @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="order_date" class="form-label">Order date <span class="text-danger">*</span></label>
                            <input type="date" id="order_date" name="order_date"
                                   class="form-control @error('order_date') is-invalid @enderror"
                                   value="{{ old('order_date', now()->toDateString()) }}" required>
                            @error('order_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                                @foreach (['pending', 'preparing'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', 'pending') === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea id="notes" name="notes" rows="2" maxlength="500"
                                  class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                        @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <h2 class="h6">Order items <span class="text-danger">*</span></h2>
                    <div id="item-rows">
                        @foreach ($lines as $i => $line)
                            @include('orders._line', ['index' => $i, 'line' => $line, 'products' => $products])
                        @endforeach
                    </div>

                    <button type="button" id="add-row" class="btn btn-sm btn-outline-success mb-4">
                        <i class="bi bi-plus"></i> Add another product
                    </button>

                    <div>
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Place Order</button>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Blank line used by the "Add another product" button --}}
<template id="row-template">
    @include('orders._line', ['index' => '__INDEX__', 'line' => ['product_id' => '', 'quantity' => 1], 'products' => $products])
</template>
@endsection

@push('scripts')
<script>
    (function () {
        var rows = document.getElementById('item-rows');
        var template = document.getElementById('row-template').innerHTML;
        var next = {{ $nextIndex }};

        document.getElementById('add-row').addEventListener('click', function () {
            rows.insertAdjacentHTML('beforeend', template.replace(/__INDEX__/g, next++));
        });

        rows.addEventListener('click', function (event) {
            var button = event.target.closest('.remove-row');
            if (!button) return;
            if (rows.querySelectorAll('.order-line').length > 1) {
                button.closest('.order-line').remove();
            } else {
                alert('An order needs at least one product.');
            }
        });
    })();
</script>
@endpush