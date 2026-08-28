@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-white">Admin Dashboard</h1>
            <p class="text-sm text-slate-600 dark:text-slate-400">Welcome to Indrasari Car Rental operational control center.</p>
        </div>
    </div>

    <!-- KPI Metric Cards Placeholder -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Fleet Vehicles</span>
            <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">0 Units</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Active Rentals</span>
            <p class="mt-2 text-2xl font-bold text-emerald-600 dark:text-emerald-400">0 Active</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Registered Users</span>
            <p class="mt-2 text-2xl font-bold text-blue-600 dark:text-blue-400">{{ \App\Models\User::count() }} Users</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Total Revenue</span>
            <p class="mt-2 text-2xl font-bold text-purple-600 dark:text-purple-400">Rp 0</p>
        </div>
    </div>
</div>
@endsection
