@extends('layouts.admin')

@section('title', 'Create brand')

@section('content')
    <h1 class="font-display text-3xl text-white">Create brand</h1>
    <form action="{{ route('admin.brands.store') }}" method="post" enctype="multipart/form-data" class="mt-8 max-w-xl space-y-4">
        @csrf
        <div>
            <label class="mg-label">Name (AR)</label>
            <input class="mg-input" name="name_ar" value="{{ old('name_ar') }}" required>
        </div>
        <div>
            <label class="mg-label">Name (EN)</label>
            <input class="mg-input" name="name_en" value="{{ old('name_en') }}" required>
        </div>
        <div>
            <label class="mg-label">Logo</label>
            <input class="mg-input" type="file" name="logo" accept="image/*">
        </div>
        <button class="mg-btn-primary" type="submit">Save</button>
    </form>
@endsection
