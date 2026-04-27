@extends('layouts.admin')

@section('title', 'Login')

@section('content')
    <div class="mx-auto max-w-md rounded-3xl border border-white/10 bg-white/[0.03] p-8">
        <h1 class="font-display text-3xl text-white">Admin login</h1>
        <form method="post" action="{{ route('admin.login.perform') }}" class="mt-8 space-y-4">
            @csrf
            <div>
                <label class="mg-label">Email</label>
                <input class="mg-input" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div>
                <label class="mg-label">Password</label>
                <input class="mg-input" type="password" name="password" required>
            </div>
            <label class="flex items-center gap-2 text-sm text-white/70">
                <input type="checkbox" name="remember" value="1" class="rounded border-white/20 bg-transparent">
                Remember me
            </label>
            @error('email')
                <p class="text-sm text-red-300">{{ $message }}</p>
            @enderror
            <button class="mg-btn-primary w-full" type="submit">Sign in</button>
        </form>
    </div>
@endsection
