@extends('layouts.admin')

@section('title', 'Coupons')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <h1 class="font-display text-3xl text-white">Coupons</h1>
        <a class="mg-btn-primary" href="{{ route('admin.coupons.create') }}">New coupon</a>
    </div>
    <div class="mt-8 overflow-x-auto rounded-2xl border border-white/10">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-white/[0.04] text-xs uppercase tracking-widest text-white/45">
                <tr>
                    <th class="px-4 py-3">Code</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Value</th>
                    <th class="px-4 py-3">Expires</th>
                    <th class="px-4 py-3">Active</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $c)
                    <tr class="border-t border-white/10">
                        <td class="px-4 py-3 font-mono">{{ $c->code }}</td>
                        <td class="px-4 py-3">{{ $c->type }}</td>
                        <td class="px-4 py-3">{{ $c->value }}</td>
                        <td class="px-4 py-3">{{ $c->expires_at?->format('Y-m-d') ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $c->is_active ? 'yes' : 'no' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a class="text-[var(--color-mg-gold)]" href="{{ route('admin.coupons.edit', $c) }}">Edit</a>
                            <form action="{{ route('admin.coupons.destroy', $c) }}" method="post" class="inline" onsubmit="return confirm('Delete?');">
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
    <div class="mt-8">{{ $coupons->links() }}</div>
@endsection
