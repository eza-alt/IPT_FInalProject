@extends('layouts.app')

@section('title', 'Add Supplier')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>Add Supplier</strong></div>
            <div class="card-body">
                <form action="{{ route('suppliers.store') }}" method="POST">
                    @include('suppliers._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection