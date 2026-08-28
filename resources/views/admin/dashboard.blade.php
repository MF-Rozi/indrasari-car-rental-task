@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header with Quick Action CTAs -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900 sm:text-3xl dark:text-white">Admin Command Center</h1>
            <p class="mt-1 text-xs text-slate-500 sm:text-sm dark:text-slate-400">
                System-wide overview of fleet inventory, active customer rentals, and financial revenue.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.cars.create') }}" class="inline-flex items-center space-x-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-semibold text-white shadow-sm shadow-blue-500/20 hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Add New Vehicle</span>
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center space-x-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-200 dark:hover:bg-slate-800">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span>All Bookings</span>
            </a>
        </div>
    </div>

    <!-- 4 KPI Performance Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- 1. Total Fleet -->
        <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Fleet</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-3xl font-black text-slate-900 dark:text-white">{{ $totalCars }}</p>
                <div class="mt-2 flex flex-wrap gap-2 text-[11px] font-semibold text-slate-500 dark:text-slate-400">
                    <span class="text-emerald-600 dark:text-emerald-400">{{ $availableCars }} Available</span> &bull;
                    <span class="text-sky-600 dark:text-sky-400">{{ $rentedCars }} Rented</span> &bull;
                    <span class="text-amber-600 dark:text-amber-400">{{ $maintenanceCars }} Maintenance</span>
                </div>
            </div>
        </div>

        <!-- 2. Active Ongoing Rentals -->
        <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Active Rentals</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-3xl font-black text-slate-900 dark:text-white">{{ $activeRentals }}</p>
                <p class="mt-2 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                    Currently in customer possession
                </p>
            </div>
        </div>

        <!-- 3. Registered Customers -->
        <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Customers</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-600 dark:bg-sky-950/60 dark:text-sky-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-3xl font-black text-slate-900 dark:text-white">{{ $totalCustomers }}</p>
                <p class="mt-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                    Verified driver accounts
                </p>
            </div>
        </div>

        <!-- 4. Total Settled Revenue -->
        <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Settled Revenue</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-950/60 dark:text-purple-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-2xl font-black text-slate-900 sm:text-3xl dark:text-white">{{ $formattedTotalRevenue }}</p>
                <p class="mt-2 text-xs font-semibold text-purple-600 dark:text-purple-400">
                    Paid invoice transactions
                </p>
            </div>
        </div>
    </div>

    <!-- Recent Booking Activity -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7 dark:border-slate-800 dark:bg-[#1E293B]">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
            <div>
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Recent Customer Bookings</h2>
                <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Latest reservation and rental activities</p>
            </div>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                View All &rarr;
            </a>
        </div>

        <div class="mt-4 overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 dark:bg-[#0F172A] dark:text-slate-400">
                    <tr>
                        <th class="px-4 py-3 font-semibold uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 font-semibold uppercase tracking-wider">Vehicle</th>
                        <th class="px-4 py-3 font-semibold uppercase tracking-wider">Rental Dates</th>
                        <th class="px-4 py-3 font-semibold uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-3 font-semibold uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 font-semibold uppercase tracking-wider text-right">Audit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-800 dark:divide-slate-800 dark:text-slate-200">
                    @forelse($recentRentals as $rental)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50">
                            <td class="px-4 py-3.5">
                                <p class="font-bold text-slate-900 dark:text-white">{{ $rental->user->name }}</p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $rental->user->email }}</p>
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="font-bold text-slate-900 dark:text-white">{{ $rental->car->brand }} {{ $rental->car->model }}</p>
                                <span class="font-mono text-[11px] font-bold text-blue-600 dark:text-blue-400">{{ $rental->car->license_plate }}</span>
                            </td>
                            <td class="px-4 py-3.5">
                                <p>{{ $rental->start_date->format('d M Y') }} &rarr; {{ $rental->end_date->format('d M Y') }}</p>
                                <p class="text-[11px] text-slate-400">({{ $rental->total_days }} Days)</p>
                            </td>
                            <td class="px-4 py-3.5 font-bold">
                                {{ $rental->isCompleted() && $rental->formatted_final_price ? $rental->formatted_final_price : $rental->formatted_estimated_price }}
                            </td>
                            <td class="px-4 py-3.5">
                                @if($rental->isActive())
                                    <span class="rounded-lg bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300">Active</span>
                                @elseif($rental->isUpcoming())
                                    <span class="rounded-lg bg-sky-100 px-2 py-0.5 text-[10px] font-bold text-sky-700 dark:bg-sky-950/60 dark:text-sky-300">Upcoming</span>
                                @elseif($rental->isCompleted())
                                    <span class="rounded-lg bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-600 dark:bg-slate-800 dark:text-slate-300">Completed</span>
                                @else
                                    <span class="rounded-lg bg-rose-100 px-2 py-0.5 text-[10px] font-bold text-rose-700 dark:bg-rose-950/60 dark:text-rose-300">Cancelled</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <a href="{{ route('admin.bookings.show', $rental) }}" class="font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                    Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                No rental bookings registered in the system yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
