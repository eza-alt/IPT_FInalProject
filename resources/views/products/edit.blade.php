@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>Edit Product</strong></div>
            <div class="card-body">
                <form action="{{ route('products.update', $product) }}" method="POST">
                    @method('PUT')
                    @include('products._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection