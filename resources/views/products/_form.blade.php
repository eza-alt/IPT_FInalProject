@csrf
<div class="mb-3">
    <label for="name" class="form-label">Product name <span class="text-danger">*</span></label>
    <input type="text" id="name" name="name" maxlength="100"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $product->name ?? '') }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
        <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
            <option value="">-- Select category --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="supplier_id" class="form-label">Supplier <span class="text-danger">*</span></label>
        <select id="supplier_id" name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
            <option value="">-- Select supplier --</option>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}" @selected(old('supplier_id', $product->supplier_id ?? '') == $supplier->id)>
                    {{ $supplier->name }}
                </option>
            @endforeach
        </select>
        @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="price" class="form-label">Price (&#8369;) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" min="0.01" id="price" name="price"
               class="form-control @error('price') is-invalid @enderror"
               value="{{ old('price', $product->price ?? '') }}" required>
        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
        <input type="number" min="0" id="stock" name="stock"
               class="form-control @error('stock') is-invalid @enderror"
               value="{{ old('stock', $product->stock ?? 0) }}" required>
        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea id="description" name="description" rows="3" maxlength="500"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-check mb-3">
    {{-- Hidden field so an unchecked box is still submitted as 0 --}}
    <input type="hidden" name="is_available" value="0">
    <input class="form-check-input" type="checkbox" id="is_available" name="is_available" value="1"
           @checked(old('is_available', $product->is_available ?? true))>
    <label class="form-check-label" for="is_available">Available for ordering</label>
</div>

<button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Save</button>
<a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancel</a>