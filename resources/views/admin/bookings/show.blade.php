@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Top Actions -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center space-x-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back to All Bookings</span>
        </a>
    </div>

    <!-- Booking Header -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center space-x-3">
                <h1 class="text-2xl font-black tracking-tight text-slate-900 sm:text-3xl dark:text-white">
                    Booking #{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}
                </h1>
                @if($rental->isActive())
                    <span class="rounded-xl bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">Active</span>
                @elseif($rental->isUpcoming())
                    <span class="rounded-xl bg-sky-100 px-3 py-1 text-xs font-bold text-sky-800 dark:bg-sky-950/60 dark:text-sky-300">Upcoming</span>
                @elseif($rental->isCompleted())
                    <span class="rounded-xl bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700 dark:bg-slate-800 dark:text-slate-300">Completed</span>
                @else
                    <span class="rounded-xl bg-rose-100 px-3 py-1 text-xs font-bold text-rose-800 dark:bg-rose-950/60 dark:text-rose-300">Cancelled</span>
                @endif
            </div>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                Created on {{ $rental->created_at->format('d M Y, H:i') }} WIB
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
        <!-- Left 8 Columns: Customer & Vehicle Information -->
        <div class="space-y-6 lg:col-span-8">
            <!-- Customer Card -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7 dark:border-slate-800 dark:bg-[#1E293B]">
                <div class="flex items-center space-x-3 border-b border-slate-100 pb-4 dark:border-slate-800">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2 class="text-base font-bold text-slate-900 dark:text-white">Customer & Driver Details</h2>
                </div>

                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 text-xs">
                    <div>
                        <span class="font-semibold text-slate-400">Full Name</span>
                        <p class="mt-1 font-bold text-slate-900 dark:text-white">{{ $rental->user->name }}</p>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-400">Email Address</span>
                        <p class="mt-1 font-bold text-slate-900 dark:text-white">{{ $rental->user->email }}</p>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-400">Phone Number</span>
                        <p class="mt-1 font-bold text-slate-900 dark:text-white">{{ $rental->user->phone_number ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-400">Driver License (SIM A)</span>
                        <p class="mt-1 font-mono font-bold text-slate-900 dark:text-white">{{ $rental->user->sim_number ?? '-' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="font-semibold text-slate-400">Address</span>
                        <p class="mt-1 font-bold text-slate-900 dark:text-white">{{ $rental->user->address ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Vehicle Card -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7 dark:border-slate-800 dark:bg-[#1E293B]">
                <div class="flex items-center space-x-3 border-b border-slate-100 pb-4 dark:border-slate-800">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                        </svg>
                    </div>
                    <h2 class="text-base font-bold text-slate-900 dark:text-white">Assigned Fleet Vehicle</h2>
                </div>

                <div class="mt-5 flex flex-col gap-5 sm:flex-row sm:items-center">
                    <div class="h-32 w-full shrink-0 overflow-hidden rounded-xl bg-slate-100 sm:w-44 dark:bg-slate-800">
                        @if($rental->car->image_path)
                            <img src="{{ Storage::url($rental->car->image_path) }}" alt="{{ $rental->car->brand }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-slate-400">
                                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="space-y-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">{{ $rental->car->brand }}</span>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ $rental->car->model }}</h3>
                        <div class="flex flex-wrap items-center gap-2 pt-1 text-xs text-slate-600 dark:text-slate-300">
                            <span class="rounded-lg bg-slate-100 px-2.5 py-1 font-mono font-bold dark:bg-slate-800">{{ $rental->car->license_plate }}</span>
                            <span class="rounded-lg bg-slate-100 px-2.5 py-1 dark:bg-slate-800">{{ $rental->car->transmission }}</span>
                            <span class="rounded-lg bg-slate-100 px-2.5 py-1 dark:bg-slate-800">{{ $rental->car->seating_capacity }} Seats</span>
                            <span class="rounded-lg bg-slate-100 px-2.5 py-1 font-bold text-blue-600 dark:bg-slate-800 dark:text-blue-400">{{ $rental->car->formatted_daily_rate }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right 4 Columns: Timeline & Invoice Settlement -->
        <div class="space-y-6 lg:col-span-4">
            <!-- Timeline Card -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Rental Schedule</h2>
                <div class="mt-4 space-y-3 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Pick-up Date:</span>
                        <span class="font-bold text-slate-900 dark:text-white">{{ $rental->start_date->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Scheduled End:</span>
                        <span class="font-bold text-slate-900 dark:text-white">{{ $rental->end_date->format('d M Y') }}</span>
                    </div>
                    @if($rental->actual_return_date)
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Actual Return:</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $rental->actual_return_date->format('d M Y') }}</span>
                        </div>
                    @endif
                    <div class="flex items-center justify-between border-t border-slate-100 pt-3 dark:border-slate-800">
                        <span class="text-slate-400">Total Duration:</span>
                        <span class="font-bold text-slate-900 dark:text-white">{{ $rental->total_days }} {{ $rental->total_days > 1 ? 'Days' : 'Day' }}</span>
                    </div>
                </div>
            </div>

            <!-- Financial Settlement Card -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Financial Summary</h2>
                <div class="mt-4 space-y-3 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Estimated Price:</span>
                        <span class="font-bold">{{ $rental->formatted_estimated_price }}</span>
                    </div>
                    @if($rental->final_price)
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Final Settled Price:</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $rental->formatted_final_price }}</span>
                        </div>
                    @endif
                    @if($rental->invoice)
                        <div class="border-t border-slate-100 pt-3 dark:border-slate-800">
                            <span class="text-[11px] font-semibold text-slate-400">Invoice Number</span>
                            <p class="font-mono font-bold text-slate-900 dark:text-white">{{ $rental->invoice->invoice_number }}</p>
                            <div class="mt-3">
                                <a href="{{ route('invoices.show', $rental->invoice) }}" class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 py-2.5 text-xs font-semibold text-white shadow-sm hover:bg-blue-700">
                                    View Digital Invoice &rarr;
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
