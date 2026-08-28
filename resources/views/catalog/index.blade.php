@extends('layouts.app')

@section('content')
<div class="py-6">
    <!-- Hero Banner -->
    <div class="rounded-3xl border border-slate-200 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 p-8 text-white shadow-xl sm:p-12 dark:border-slate-700">
        <div class="max-w-2xl">
            <span class="inline-flex items-center rounded-lg bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider backdrop-blur">
                Premium Fleet Rental
            </span>
            <h1 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">
                Find the Perfect Vehicle for Your Journey
            </h1>
            <p class="mt-3 text-base text-blue-100">
                Experience seamless car rentals with verified availability, transparent daily pricing, and hassle-free returns.
            </p>
        </div>
    </div>

    <!-- Catalog Content Notice -->
    <div class="mt-10 rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <h2 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">Vehicle Fleet Catalog</h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Fleet inventory management and real-time vehicle booking search will be populated in Feature 2 & 3.
        </p>
    </div>
</div>
@endsection
