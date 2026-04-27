@extends('layouts.admin')

@section('title', 'Edit product')

@section('content')
    <h1 class="font-display text-3xl text-white">Edit product</h1>
    <form action="{{ route('admin.products.update', $product) }}" method="post" enctype="multipart/form-data" class="mt-8 max-w-3xl space-y-4">
        @csrf
        @method('PUT')
        @include('admin.products._form', ['product' => $product])
        <label class="flex items-center gap-2 text-sm text-white/70">
            <input type="checkbox" name="regenerate_slug" value="1" class="rounded border-white/20 bg-transparent">
            Regenerate slug from English name
        </label>
        <button class="mg-btn-primary" type="submit">Update</button>
    </form>

    @if ($product->images->isNotEmpty())
        <div class="mt-10 max-w-3xl">
            <h2 class="text-lg text-white">Images</h2>
            <div class="mt-4 grid grid-cols-2 gap-4 md:grid-cols-4">
                @foreach ($product->images as $img)
                    <div class="relative overflow-hidden rounded-xl border border-white/10">
                        <img src="{{ asset('storage/'.$img->path) }}" class="h-32 w-full object-cover" alt="">
                        <form action="{{ route('admin.products.images.destroy', $img) }}" method="post" class="absolute right-2 top-2" onsubmit="return confirm('Delete image?');">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-full bg-black/70 px-2 py-1 text-xs text-red-200" type="submit">×</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
