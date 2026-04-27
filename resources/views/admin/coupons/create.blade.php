@extends('layouts.admin')

@section('title', 'Create coupon')

@section('content')
    <h1 class="font-display text-3xl text-white">Create coupon</h1>
    <form action="{{ route('admin.coupons.store') }}" method="post" class="mt-8 max-w-xl space-y-4">
        @csrf
        <div>
            <label class="mg-label">Code</label>
            <input class="mg-input" name="code" value="{{ old('code') }}" required>
        </div>
        <div>
            <label class="mg-label">Type</label>
            <select class="mg-input" name="type">
                <option value="percent" @selected(old('type') === 'percent')>percent</option>
                <option value="fixed" @selected(old('type') === 'fixed')>fixed</option>
            </select>
        </div>
        <div>
            <label class="mg-label">Value</label>
            <input class="mg-input" type="number" step="0.01" name="value" value="{{ old('value') }}" required>
        </div>
        <div>
            <label class="mg-label">Expires at</label>
            <input class="mg-input" type="date" name="expires_at" value="{{ old('expires_at') }}">
        </div>
        <label class="flex items-center gap-2 text-sm text-white/70">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))>
            Active
        </label>
        <button class="mg-btn-primary" type="submit">Save</button>
    </form>
@endsection
