@extends('layouts.admin')

@section('title', 'Edit category')

@section('content')
    <h1 class="font-display text-3xl text-white">Edit category</h1>
    <form action="{{ route('admin.categories.update', $category) }}" method="post" class="mt-8 max-w-xl space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="mg-label">Name (AR)</label>
            <input class="mg-input" name="name_ar" value="{{ old('name_ar', $category->name_ar) }}" required>
        </div>
        <div>
            <label class="mg-label">Name (EN)</label>
            <input class="mg-input" name="name_en" value="{{ old('name_en', $category->name_en) }}" required>
        </div>
        <label class="flex items-center gap-2 text-sm text-white/70">
            <input type="checkbox" name="regenerate_slug" value="1" class="rounded border-white/20 bg-transparent">
            Regenerate slug
        </label>
        <button class="mg-btn-primary" type="submit">Update</button>
    </form>
@endsection
