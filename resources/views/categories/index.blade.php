@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h1 class="h3 mb-0">Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-success"><i class="bi bi-plus-circle"></i> Add Category</a>
</div>

<form method="GET" action="{{ route('categories.index') }}" class="row g-2 mb-3">
    <div class="col-sm-6 col-md-4">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search categories...">
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-secondary"><i class="bi bi-search"></i> Search</button>
        @if (request('q'))
            <a href="{{ route('categories.index') }}" class="btn btn-link">Clear</a>
        @endif
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Name</th><th>Description</th><th class="text-center">Products</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td class="text-muted">{{ \Illuminate\Support\Str::limit($category->description, 60) }}</td>
                        <td class="text-center"><span class="badge bg-secondary">{{ $category->products_count }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete category {{ addslashes($category->name) }}?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No categories found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $categories->links() }}</div>
@endsection