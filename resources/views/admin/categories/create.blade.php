@extends('layouts.admin')

@section('title', 'Create category')

@section('content')
    <h1 class="font-display text-3xl text-white">Create category</h1>
    <form action="{{ route('admin.categories.store') }}" method="post" class="mt-8 max-w-xl space-y-4">
        @csrf
        <div>
            <label class="mg-label">Name (AR)</label>
            <input class="mg-input" name="name_ar" value="{{ old('name_ar') }}" required>
        </div>
        <div>
            <label class="mg-label">Name (EN)</label>
            <input class="mg-input" name="name_en" value="{{ old('name_en') }}" required>
        </div>
        <button class="mg-btn-primary" type="submit">Save</button>
    </form>
@endsection
