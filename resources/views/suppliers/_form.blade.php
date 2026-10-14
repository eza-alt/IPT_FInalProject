@csrf
<div class="mb-3">
    <label for="name" class="form-label">Supplier name <span class="text-danger">*</span></label>
    <input type="text" id="name" name="name" maxlength="100"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $supplier->name ?? '') }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="contact_person" class="form-label">Contact person</label>
        <input type="text" id="contact_person" name="contact_person" maxlength="100"
               class="form-control @error('contact_person') is-invalid @enderror"
               value="{{ old('contact_person', $supplier->contact_person ?? '') }}">
        @error('contact_person') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" id="phone" name="phone" maxlength="30"
               class="form-control @error('phone') is-invalid @enderror"
               value="{{ old('phone', $supplier->phone ?? '') }}">
        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" name="email" maxlength="120"
           class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email', $supplier->email ?? '') }}">
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <input type="text" id="address" name="address" maxlength="255"
           class="form-control @error('address') is-invalid @enderror"
           value="{{ old('address', $supplier->address ?? '') }}">
    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Save</button>
<a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Cancel</a>