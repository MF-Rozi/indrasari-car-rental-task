@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900 sm:text-3xl dark:text-white">Customer Bookings and Rentals</h1>
            <p class="mt-1 text-xs text-slate-500 sm:text-sm dark:text-slate-400">
                System-wide audit log of all customer reservations, ongoing rentals, and completed returns.
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center space-x-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-200 dark:hover:bg-slate-800">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Dashboard Overview</span>
        </a>
    </div>

    <!-- Status Tabs -->
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-4 dark:border-slate-800">
        <a href="{{ route('admin.bookings.index', ['status' => 'all', 'search' => $currentSearch, 'date' => $currentDate]) }}"
            class="inline-flex items-center space-x-2 rounded-xl px-4 py-2 text-xs font-semibold transition-all {{ $currentStatus === 'all' ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800' }}">
            <span>All Bookings</span>
            <span class="rounded-full px-2 py-0.5 text-[10px] {{ $currentStatus === 'all' ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">{{ $allCount }}</span>
        </a>

        <a href="{{ route('admin.bookings.index', ['status' => 'active', 'search' => $currentSearch, 'date' => $currentDate]) }}"
            class="inline-flex items-center space-x-2 rounded-xl px-4 py-2 text-xs font-semibold transition-all {{ $currentStatus === 'active' ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800' }}">
            <span>Active</span>
            <span class="rounded-full px-2 py-0.5 text-[10px] {{ $currentStatus === 'active' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300' }}">{{ $activeCount }}</span>
        </a>

        <a href="{{ route('admin.bookings.index', ['status' => 'completed', 'search' => $currentSearch, 'date' => $currentDate]) }}"
            class="inline-flex items-center space-x-2 rounded-xl px-4 py-2 text-xs font-semibold transition-all {{ $currentStatus === 'completed' ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800' }}">
            <span>Completed</span>
            <span class="rounded-full px-2 py-0.5 text-[10px] {{ $currentStatus === 'completed' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400' }}">{{ $completedCount }}</span>
        </a>

        <a href="{{ route('admin.bookings.index', ['status' => 'cancelled', 'search' => $currentSearch, 'date' => $currentDate]) }}"
            class="inline-flex items-center space-x-2 rounded-xl px-4 py-2 text-xs font-semibold transition-all {{ $currentStatus === 'cancelled' ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800' }}">
            <span>Cancelled</span>
            <span class="rounded-full px-2 py-0.5 text-[10px] {{ $currentStatus === 'cancelled' ? 'bg-white/20 text-white' : 'bg-rose-100 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300' }}">{{ $cancelledCount }}</span>
        </a>
    </div>

    <!-- Search & Date Filter Bar -->
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5 dark:border-slate-800 dark:bg-[#1E293B]">
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-12">
            <input type="hidden" name="status" value="{{ $currentStatus }}">

            <div class="lg:col-span-6">
                <label for="search" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">Search Bookings</label>
                <div class="relative mt-1">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" id="search" name="search" value="{{ $currentSearch }}" placeholder="Customer name, email, SIM, car model, or plate..."
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-xs text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500">
                </div>
            </div>

            <div class="lg:col-span-4">
                <label for="date" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">Active on Date</label>
                <input type="date" id="date" name="date" value="{{ $currentDate }}"
                    class="mt-1 block w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-xs text-slate-900 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white">
            </div>

            <div class="flex items-end lg:col-span-2">
                <button type="submit" class="flex w-full items-center justify-center space-x-2 rounded-xl bg-blue-600 py-2.5 text-xs font-semibold text-white shadow-sm hover:bg-blue-700">
                    <span>Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Bookings Data Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 dark:bg-[#0F172A] dark:text-slate-400">
                    <tr>
                        <th class="px-5 py-3.5 font-semibold uppercase tracking-wider">Ref #</th>
                        <th class="px-5 py-3.5 font-semibold uppercase tracking-wider">Customer Info</th>
                        <th class="px-5 py-3.5 font-semibold uppercase tracking-wider">Vehicle Details</th>
                        <th class="px-5 py-3.5 font-semibold uppercase tracking-wider">Rental Window</th>
                        <th class="px-5 py-3.5 font-semibold uppercase tracking-wider">Amount</th>
                        <th class="px-5 py-3.5 font-semibold uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3.5 font-semibold uppercase tracking-wider text-right">Audit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-800 dark:divide-slate-800 dark:text-slate-200">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50">
                            <td class="px-5 py-4 font-mono font-bold text-slate-600 dark:text-slate-400">
                                #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-bold text-slate-900 dark:text-white">{{ $booking->user->name }}</p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $booking->user->email }}</p>
                                @if($booking->user->sim_number)
                                    <span class="inline-block mt-0.5 rounded bg-slate-100 px-1.5 py-0.2 font-mono text-[10px] font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                        SIM: {{ $booking->user->sim_number }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-bold text-slate-900 dark:text-white">{{ $booking->car->brand }} {{ $booking->car->model }}</p>
                                <span class="font-mono text-[11px] font-bold text-blue-600 dark:text-blue-400">{{ $booking->car->license_plate }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <p>{{ $booking->start_date->format('d M Y') }} &rarr; {{ $booking->end_date->format('d M Y') }}</p>
                                <p class="text-[11px] text-slate-400">({{ $booking->total_days }} Days)</p>
                            </td>
                            <td class="px-5 py-4 font-bold">
                                {{ $booking->isCompleted() && $booking->formatted_final_price ? $booking->formatted_final_price : $booking->formatted_estimated_price }}
                            </td>
                            <td class="px-5 py-4">
                                @if($booking->isActive())
                                    <span class="rounded-lg bg-emerald-100 px-2.5 py-1 text-[11px] font-bold text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300">Active</span>
                                @elseif($booking->isUpcoming())
                                    <span class="rounded-lg bg-sky-100 px-2.5 py-1 text-[11px] font-bold text-sky-700 dark:bg-sky-950/60 dark:text-sky-300">Upcoming</span>
                                @elseif($booking->isCompleted())
                                    <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-slate-600 dark:bg-slate-800 dark:text-slate-300">Completed</span>
                                @else
                                    <span class="rounded-lg bg-rose-100 px-2.5 py-1 text-[11px] font-bold text-rose-700 dark:bg-rose-950/60 dark:text-rose-300">Cancelled</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="inline-flex items-center space-x-1 rounded-lg border border-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                                    <span>Audit</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-slate-400">
                                No customer bookings match your selected filter criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="border-t border-slate-200 p-4 dark:border-slate-800">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
