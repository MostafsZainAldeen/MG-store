@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
    <h1 class="font-display text-3xl text-white">Orders</h1>
    <form method="get" class="mt-6 flex flex-wrap gap-3">
        <select class="mg-input w-56" name="status" onchange="this.form.submit()">
            <option value="all" @selected(($status ?? '') === 'all' || ($status ?? '') === '')>All</option>
            <option value="pending" @selected(($status ?? '') === 'pending')>pending</option>
            <option value="confirmed" @selected(($status ?? '') === 'confirmed')>confirmed</option>
            <option value="shipped" @selected(($status ?? '') === 'shipped')>shipped</option>
            <option value="delivered" @selected(($status ?? '') === 'delivered')>delivered</option>
            <option value="cancelled" @selected(($status ?? '') === 'cancelled')>cancelled</option>
        </select>
    </form>

    <div class="mt-8 overflow-x-auto rounded-2xl border border-white/10">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-white/[0.04] text-xs uppercase tracking-widest text-white/45">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Phone</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $o)
                    <tr class="border-t border-white/10">
                        <td class="px-4 py-3 font-mono text-xs">{{ $o->order_number }}</td>
                        <td class="px-4 py-3">{{ $o->full_name }}</td>
                        <td class="px-4 py-3">{{ $o->phone }}</td>
                        <td class="px-4 py-3">{{ number_format((float) $o->total, 2) }} {{ $o->currency }}</td>
                        <td class="px-4 py-3">{{ $o->status }}</td>
                        <td class="px-4 py-3 text-right"><a class="text-[var(--color-mg-gold)]" href="{{ route('admin.orders.show', $o) }}">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-8">{{ $orders->links() }}</div>
@endsection
