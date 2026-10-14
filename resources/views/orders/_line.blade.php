<div class="order-line row g-2 mb-2 align-items-start">
    <div class="col-sm-8">
        <select name="items[{{ $index }}][product_id]"
                class="form-select @error('items.' . $index . '.product_id') is-invalid @enderror" required>
            <option value="">-- Select product --</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" @selected(($line['product_id'] ?? '') == $product->id)>
                    {{ $product->name }} - &#8369;{{ number_format($product->price, 2) }} ({{ $product->stock }} in stock)
                </option>
            @endforeach
        </select>
        @error('items.' . $index . '.product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-8 col-sm-3">
        <input type="number" min="1" max="100" name="items[{{ $index }}][quantity]" placeholder="Qty"
               class="form-control @error('items.' . $index . '.quantity') is-invalid @enderror"
               value="{{ $line['quantity'] ?? 1 }}" required>
        @error('items.' . $index . '.quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-4 col-sm-1">
        <button type="button" class="btn btn-outline-danger remove-row w-100" title="Remove line">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
</div>