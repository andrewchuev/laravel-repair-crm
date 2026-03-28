@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Sign in</h1>
            <p class="mt-2 text-sm text-slate-500">Use your CRM account to continue.</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm shadow-sm outline-none ring-0 transition focus:border-slate-500">
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                <input id="password" name="password" type="password" required
                    class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm shadow-sm outline-none ring-0 transition focus:border-slate-500">
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="inline-flex w-full items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800">
                    Sign in
                </button>
            </div>
        </form>
    </div>
@endsection
