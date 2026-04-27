@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <h1 class="font-display text-3xl text-white">Categories</h1>
        <a class="mg-btn-primary" href="{{ route('admin.categories.create') }}">New category</a>
    </div>
    <div class="mt-8 overflow-x-auto rounded-2xl border border-white/10">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-white/[0.04] text-xs uppercase tracking-widest text-white/45">
                <tr>
                    <th class="px-4 py-3">EN</th>
                    <th class="px-4 py-3">AR</th>
                    <th class="px-4 py-3">Slug</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $c)
                    <tr class="border-t border-white/10">
                        <td class="px-4 py-3">{{ $c->name_en }}</td>
                        <td class="px-4 py-3">{{ $c->name_ar }}</td>
                        <td class="px-4 py-3 font-mono text-xs">{{ $c->slug }}</td>
                        <td class="px-4 py-3 text-right">
                            <a class="text-[var(--color-mg-gold)]" href="{{ route('admin.categories.edit', $c) }}">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $c) }}" method="post" class="inline" onsubmit="return confirm('Delete?');">
                                @csrf
                                @method('DELETE')
                                <button class="ml-3 text-red-300" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-8">{{ $categories->links() }}</div>
@endsection
