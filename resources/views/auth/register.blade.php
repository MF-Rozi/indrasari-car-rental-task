@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-xl py-6 sm:py-10">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xl sm:p-10 dark:border-slate-800 dark:bg-[#1E293B]">
        <!-- Header -->
        <div class="mb-8 text-center">
            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-500/25">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-white">Create an Account</h1>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                Register to browse our premium fleet, reserve vehicles, and manage your rentals effortlessly.
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Full Name <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                    class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500 dark:focus:border-blue-400 @error('name') border-rose-500 @enderror"
                    placeholder="e.g. Budi Santoso">
                @error('name')
                    <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Email Address <span class="text-rose-500">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500 dark:focus:border-blue-400 @error('email') border-rose-500 @enderror"
                    placeholder="budi@example.com">
                @error('email')
                    <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Number & Driver License (SIM) -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="phone_number" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Phone Number <span class="text-rose-500">*</span>
                    </label>
                    <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                        class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500 dark:focus:border-blue-400 @error('phone_number') border-rose-500 @enderror"
                        placeholder="081234567890">
                    @error('phone_number')
                        <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sim_number" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Driver's License (SIM) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="sim_number" name="sim_number" value="{{ old('sim_number') }}" required
                        class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500 dark:focus:border-blue-400 @error('sim_number') border-rose-500 @enderror"
                        placeholder="1234-5678-9012">
                    @error('sim_number')
                        <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Physical Address -->
            <div>
                <label for="address" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Physical Address <span class="text-rose-500">*</span>
                </label>
                <textarea id="address" name="address" rows="3" required
                    class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500 dark:focus:border-blue-400 @error('address') border-rose-500 @enderror"
                    placeholder="Enter your complete home or billing address">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password & Confirmation -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Password <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" id="password" name="password" required
                        class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500 dark:focus:border-blue-400 @error('password') border-rose-500 @enderror"
                        placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Confirm Password <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500 dark:focus:border-blue-400"
                        placeholder="••••••••">
                </div>
            </div>

            <!-- Submit Action -->
            <div class="pt-3">
                <button type="submit" class="w-full rounded-xl bg-blue-600 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    Complete Registration
                </button>
            </div>
        </form>

        <div class="mt-6 border-t border-slate-100 pt-6 text-center dark:border-slate-700/60">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-500 dark:text-blue-400">
                    Sign In here
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
