@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h1 class="h3 mb-0">Suppliers</h1>
    <a href="{{ route('suppliers.create') }}" class="btn btn-success"><i class="bi bi-plus-circle"></i> Add Supplier</a>
</div>

<form method="GET" action="{{ route('suppliers.index') }}" class="row g-2 mb-3">
    <div class="col-sm-6 col-md-4">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search suppliers...">
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-secondary"><i class="bi bi-search"></i> Search</button>
        @if (request('q'))
            <a href="{{ route('suppliers.index') }}" class="btn btn-link">Clear</a>
        @endif
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Name</th><th>Contact</th><th>Phone</th><th>Email</th><th class="text-center">Products</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $supplier)
                    <tr>
                        <td class="fw-semibold">{{ $supplier->name }}</td>
                        <td>{{ $supplier->contact_person ?: '-' }}</td>
                        <td>{{ $supplier->phone ?: '-' }}</td>
                        <td>{{ $supplier->email ?: '-' }}</td>
                        <td class="text-center"><span class="badge bg-secondary">{{ $supplier->products_count }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete supplier {{ addslashes($supplier->name) }}?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No suppliers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $suppliers->links() }}</div>
@endsection