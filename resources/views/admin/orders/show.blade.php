@extends('layouts.admin')

@section('title', $order->order_number)

@section('content')
    <div class="flex flex-wrap items-start justify-between gap-6">
        <div>
            <h1 class="font-display text-3xl text-white">{{ $order->order_number }}</h1>
            <p class="mt-2 text-sm text-white/60">{{ $order->created_at }}</p>
        </div>
        <form action="{{ route('admin.orders.status', $order) }}" method="post" class="flex flex-wrap items-center gap-3">
            @csrf
            @method('PATCH')
            <select class="mg-input" name="status">
                @foreach (['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'] as $s)
                    <option value="{{ $s }}" @selected($order->status === $s)>{{ $s }}</option>
                @endforeach
            </select>
            <button class="mg-btn-primary" type="submit">Update status</button>
        </form>
    </div>

    <div class="mt-10 grid gap-8 lg:grid-cols-2">
        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6">
            <h2 class="text-lg text-white">Customer</h2>
            <dl class="mt-4 space-y-2 text-sm text-white/75">
                <div><dt class="text-white/45">Name</dt><dd>{{ $order->full_name }}</dd></div>
                <div><dt class="text-white/45">Phone</dt><dd>{{ $order->phone }}</dd></div>
                <div><dt class="text-white/45">City</dt><dd>{{ $order->city }}</dd></div>
                <div><dt class="text-white/45">Address</dt><dd>{{ $order->address }}</dd></div>
                @if ($order->notes)
                    <div><dt class="text-white/45">Notes</dt><dd>{{ $order->notes }}</dd></div>
                @endif
                @if ($order->delivery_details)
                    <div><dt class="text-white/45">Delivery</dt><dd>{{ $order->delivery_details }}</dd></div>
                @endif
            </dl>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-6">
            <h2 class="text-lg text-white">Totals</h2>
            <dl class="mt-4 space-y-2 text-sm text-white/75">
                <div class="flex justify-between"><dt>Subtotal</dt><dd>{{ number_format((float) $order->subtotal, 2) }} {{ $order->currency }}</dd></div>
                <div class="flex justify-between"><dt>Discount</dt><dd>{{ number_format((float) $order->discount_amount, 2) }} {{ $order->currency }}</dd></div>
                <div class="flex justify-between text-lg text-white"><dt>Total</dt><dd>{{ number_format((float) $order->total, 2) }} {{ $order->currency }}</dd></div>
                @if ($order->coupon)
                    <div class="text-xs text-white/45">Coupon: {{ $order->coupon->code }}</div>
                @endif
            </dl>
        </div>
    </div>

    <div class="mt-10">
        <h2 class="text-lg text-white">Items</h2>
        <div class="mt-4 overflow-x-auto rounded-2xl border border-white/10">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-white/[0.04] text-xs uppercase tracking-widest text-white/45">
                    <tr>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">Qty</th>
                        <th class="px-4 py-3">Unit</th>
                        <th class="px-4 py-3">Line</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr class="border-t border-white/10">
                            <td class="px-4 py-3">{{ $item->name_en }}</td>
                            <td class="px-4 py-3">{{ $item->quantity }}</td>
                            <td class="px-4 py-3">{{ number_format((float) $item->unit_price, 2) }}</td>
                            <td class="px-4 py-3">{{ number_format((float) $item->line_total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
