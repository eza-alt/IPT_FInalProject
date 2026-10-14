@extends('layouts.app')

@section('title', 'Add Category')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>Add Category</strong></div>
            <div class="card-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @include('categories._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection