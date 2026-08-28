@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-md py-8 sm:py-16">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xl sm:p-10 dark:border-slate-800 dark:bg-[#1E293B]">
        <!-- Header -->
        <div class="mb-8 text-center">
            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-500/25">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Sign In</h1>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                Welcome back to Indrasari Car Rental portal.
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Email Address
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500 dark:focus:border-blue-400 @error('email') border-rose-500 @enderror"
                    placeholder="you@example.com">
                @error('email')
                    <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Password
                    </label>
                </div>
                <input type="password" id="password" name="password" required
                    class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500 dark:focus:border-blue-400 @error('password') border-rose-500 @enderror"
                    placeholder="••••••••">
                @error('password')
                    <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 dark:border-slate-700 dark:bg-[#0F172A]">
                    <span class="text-xs text-slate-600 dark:text-slate-400">Remember my session</span>
                </label>
            </div>

            <!-- Submit Action -->
            <div class="pt-2">
                <button type="submit" class="w-full rounded-xl bg-blue-600 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    Sign In
                </button>
            </div>
        </form>

        <div class="mt-6 border-t border-slate-100 pt-6 text-center dark:border-slate-700/60">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Don't have an account yet?
                <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-500 dark:text-blue-400">
                    Register now
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
