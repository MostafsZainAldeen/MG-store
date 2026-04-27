@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="font-display text-4xl text-white">Dashboard</h1>
    <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6">
            <p class="text-xs uppercase tracking-widest text-white/45">Products</p>
            <p class="mt-3 text-3xl text-[var(--color-mg-gold)]">{{ $stats['products'] }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6">
            <p class="text-xs uppercase tracking-widest text-white/45">Orders</p>
            <p class="mt-3 text-3xl text-[var(--color-mg-gold)]">{{ $stats['orders'] }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6">
            <p class="text-xs uppercase tracking-widest text-white/45">Pending</p>
            <p class="mt-3 text-3xl text-[var(--color-mg-gold)]">{{ $stats['pending'] }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6">
            <p class="text-xs uppercase tracking-widest text-white/45">Delivered</p>
            <p class="mt-3 text-3xl text-[var(--color-mg-gold)]">{{ $stats['delivered'] }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6">
            <p class="text-xs uppercase tracking-widest text-white/45">Revenue</p>
            <p class="mt-3 text-2xl text-[var(--color-mg-gold)]">{{ number_format((float) $stats['revenue'], 2) }}</p>
        </div>
    </div>

    <div class="mt-12">
        <h2 class="font-display text-2xl text-white">Recent orders</h2>
        <div class="mt-6 overflow-x-auto rounded-2xl border border-white/10">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-white/[0.04] text-xs uppercase tracking-widest text-white/45">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentOrders as $o)
                        <tr class="border-t border-white/10">
                            <td class="px-4 py-3 font-mono text-xs">{{ $o->order_number }}</td>
                            <td class="px-4 py-3">{{ $o->full_name }}</td>
                            <td class="px-4 py-3">{{ number_format((float) $o->total, 2) }} {{ $o->currency }}</td>
                            <td class="px-4 py-3">{{ $o->status }}</td>
                            <td class="px-4 py-3 text-right"><a class="text-[var(--color-mg-gold)]" href="{{ route('admin.orders.show', $o) }}">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
