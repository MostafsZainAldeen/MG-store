@extends('layouts.admin')

@section('title', 'Edit brand')

@section('content')
    <h1 class="font-display text-3xl text-white">Edit brand</h1>
    <form action="{{ route('admin.brands.update', $brand) }}" method="post" enctype="multipart/form-data" class="mt-8 max-w-xl space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="mg-label">Name (AR)</label>
            <input class="mg-input" name="name_ar" value="{{ old('name_ar', $brand->name_ar) }}" required>
        </div>
        <div>
            <label class="mg-label">Name (EN)</label>
            <input class="mg-input" name="name_en" value="{{ old('name_en', $brand->name_en) }}" required>
        </div>
        <div>
            <label class="mg-label">Logo</label>
            <input class="mg-input" type="file" name="logo" accept="image/*">
            @if ($brand->logo_path)
                <img src="{{ asset('storage/'.$brand->logo_path) }}" class="mt-3 h-12" alt="">
            @endif
        </div>
        <label class="flex items-center gap-2 text-sm text-white/70">
            <input type="checkbox" name="regenerate_slug" value="1" class="rounded border-white/20 bg-transparent">
            Regenerate slug
        </label>
        <button class="mg-btn-primary" type="submit">Update</button>
    </form>
@endsection
