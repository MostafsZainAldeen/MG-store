@extends('layouts.admin')

@section('title', 'Reviews')

@section('content')
    <h1 class="font-display text-3xl text-white">Product reviews</h1>
    <div class="mt-8 overflow-x-auto rounded-2xl border border-white/10">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-white/[0.04] text-xs uppercase tracking-widest text-white/45">
                <tr>
                    <th class="px-4 py-3">Product</th>
                    <th class="px-4 py-3">Author</th>
                    <th class="px-4 py-3">Rating</th>
                    <th class="px-4 py-3">Approved</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $r)
                    <tr class="border-t border-white/10">
                        <td class="px-4 py-3">{{ $r->product?->name_en }}</td>
                        <td class="px-4 py-3">{{ $r->author_name }}</td>
                        <td class="px-4 py-3">{{ $r->rating }}</td>
                        <td class="px-4 py-3">{{ $r->is_approved ? 'yes' : 'no' }}</td>
                        <td class="px-4 py-3 text-right">
                            @if (! $r->is_approved)
                                <form action="{{ route('admin.reviews.approve', $r) }}" method="post" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="text-emerald-300" type="submit">Approve</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.reviews.reject', $r) }}" method="post" class="inline" onsubmit="return confirm('Delete review?');">
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
    <div class="mt-8">{{ $reviews->links() }}</div>
@endsection
