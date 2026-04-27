@extends('layouts.admin')

@section('title', 'Edit coupon')

@section('content')
    <h1 class="font-display text-3xl text-white">Edit coupon</h1>
    <form action="{{ route('admin.coupons.update', $coupon) }}" method="post" class="mt-8 max-w-xl space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="mg-label">Code</label>
            <input class="mg-input" name="code" value="{{ old('code', $coupon->code) }}" required>
        </div>
        <div>
            <label class="mg-label">Type</label>
            <select class="mg-input" name="type">
                <option value="percent" @selected(old('type', $coupon->type) === 'percent')>percent</option>
                <option value="fixed" @selected(old('type', $coupon->type) === 'fixed')>fixed</option>
            </select>
        </div>
        <div>
            <label class="mg-label">Value</label>
            <input class="mg-input" type="number" step="0.01" name="value" value="{{ old('value', $coupon->value) }}" required>
        </div>
        <div>
            <label class="mg-label">Expires at</label>
            <input class="mg-input" type="date" name="expires_at" value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d')) }}">
        </div>
        <label class="flex items-center gap-2 text-sm text-white/70">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $coupon->is_active))>
            Active
        </label>
        <button class="mg-btn-primary" type="submit">Update</button>
    </form>
@endsection
