@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <h1 class="font-display text-3xl text-white">Products</h1>
        <a class="mg-btn-primary" href="{{ route('admin.products.create') }}">New product</a>
    </div>
    <div class="mt-8 overflow-x-auto rounded-2xl border border-white/10">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-white/[0.04] text-xs uppercase tracking-widest text-white/45">
                <tr>
                    <th class="px-4 py-3">Name (EN)</th>
                    <th class="px-4 py-3">Brand</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Stock</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $p)
                    <tr class="border-t border-white/10">
                        <td class="px-4 py-3">{{ $p->name_en }}</td>
                        <td class="px-4 py-3">{{ $p->brand?->name_en }}</td>
                        <td class="px-4 py-3">{{ number_format((float) $p->price, 2) }}</td>
                        <td class="px-4 py-3">{{ $p->stock }}</td>
                        <td class="px-4 py-3 text-right">
                            <a class="text-[var(--color-mg-gold)]" href="{{ route('admin.products.edit', $p) }}">Edit</a>
                            <form action="{{ route('admin.products.destroy', $p) }}" method="post" class="inline" onsubmit="return confirm('Delete?');">
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
    <div class="mt-8">{{ $products->links() }}</div>
@endsection
