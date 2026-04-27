@extends('layouts.admin')

@section('title', 'Create product')

@section('content')
    <h1 class="font-display text-3xl text-white">Create product</h1>
    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data" class="mt-8 max-w-3xl space-y-4">
        @csrf
        @include('admin.products._form', ['product' => null])
        <button class="mg-btn-primary" type="submit">Save</button>
    </form>
@endsection
