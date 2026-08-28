@extends('layouts.app')

@section('content')
<div class="space-y-8 py-2 sm:py-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-black tracking-tight text-slate-900 sm:text-3xl dark:text-white">Return Rented Vehicle</h1>
        <p class="mt-1 text-xs text-slate-500 sm:text-sm dark:text-slate-400">
            Enter the vehicle license plate number or select from your active rentals below to complete your return.
        </p>
    </div>

    <!-- Active Rentals Quick-Select (If available) -->
    @if($activeRentals->isNotEmpty())
        <div class="space-y-3">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Your Active Ongoing Rentals (Click to Select)</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($activeRentals as $activeRental)
                    <a href="{{ route('rentals.return', ['license_plate' => $activeRental->car->license_plate]) }}"
                        class="group flex items-center justify-between rounded-2xl border p-4 shadow-sm transition-all {{ $licensePlate === $activeRental->car->license_plate ? 'border-blue-600 bg-blue-50/50 dark:border-blue-500 dark:bg-blue-950/40' : 'border-slate-200 bg-white hover:border-slate-300 dark:border-slate-800 dark:bg-[#1E293B] dark:hover:border-slate-700' }}">
                        <div class="flex items-center space-x-3">
                            <div class="h-12 w-16 shrink-0 overflow-hidden rounded-lg bg-slate-100 dark:bg-slate-800">
                                @if($activeRental->car->image_path)
                                    <img src="{{ Storage::url($activeRental->car->image_path) }}" alt="{{ $activeRental->car->brand }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-slate-400">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900 dark:text-white">{{ $activeRental->car->brand }} {{ $activeRental->car->model }}</p>
                                <span class="font-mono text-[11px] font-bold text-blue-600 dark:text-blue-400">{{ $activeRental->car->license_plate }}</span>
                            </div>
                        </div>
                        <span class="rounded-lg bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300">
                            Active
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
        <!-- Left Column: Search by Plate -->
        <div class="space-y-6 lg:col-span-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 dark:border-slate-800 dark:bg-[#1E293B]">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Verify by License Plate (Nomor Polisi)</h2>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Input the plate number of the vehicle you are returning.
                </p>

                <form method="GET" action="{{ route('rentals.return') }}" class="mt-6 space-y-4">
                    <div>
                        <label for="license_plate" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            License Plate Number <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="license_plate" name="license_plate" value="{{ $licensePlate }}" placeholder="e.g. B 1234 XYZ" required
                            class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 font-mono text-base font-bold uppercase tracking-wider text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500">
                    </div>

                    <button type="submit" class="flex w-full items-center justify-center space-x-2 rounded-xl bg-blue-600 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span>Verify Vehicle</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Column: Verification & Final Return Confirmation -->
        <div class="space-y-6 lg:col-span-6">
            @if($verifiedRental && $summary)
                <div class="rounded-2xl border border-blue-200 bg-white p-6 shadow-xl dark:border-slate-800 dark:bg-[#1E293B]">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Vehicle Verified</span>
                        <span class="rounded-lg bg-slate-100 px-2.5 py-1 font-mono text-xs font-bold text-slate-800 dark:bg-slate-800 dark:text-slate-200">
                            {{ $verifiedRental->car->license_plate }}
                        </span>
                    </div>

                    <div class="mt-4 flex items-center space-x-4">
                        <div class="h-20 w-28 shrink-0 overflow-hidden rounded-xl bg-slate-100 dark:bg-slate-800">
                            @if($verifiedRental->car->image_path)
                                <img src="{{ Storage::url($verifiedRental->car->image_path) }}" alt="{{ $verifiedRental->car->brand }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-slate-400">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">{{ $verifiedRental->car->brand }}</span>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ $verifiedRental->car->model }}</h3>
                        </div>
                    </div>

                    <!-- Return Breakdown Table -->
                    <div class="mt-6 rounded-2xl border border-slate-100 bg-slate-50 p-4 space-y-2 text-xs dark:border-slate-800 dark:bg-[#0F172A]">
                        <div class="flex items-center justify-between text-slate-600 dark:text-slate-400">
                            <span>Pick-up Date:</span>
                            <span class="font-bold text-slate-900 dark:text-white">{{ \Carbon\Carbon::parse($summary['start_date'])->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600 dark:text-slate-400">
                            <span>Actual Return Date:</span>
                            <span class="font-bold text-slate-900 dark:text-white">{{ \Carbon\Carbon::parse($summary['return_date'])->format('d M Y') }} (Today)</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600 dark:text-slate-400">
                            <span>Elapsed Duration:</span>
                            <span class="font-bold text-slate-900 dark:text-white">{{ $summary['elapsed_days'] }} {{ $summary['elapsed_days'] > 1 ? 'Days' : 'Day' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600 dark:text-slate-400">
                            <span>Daily Rate:</span>
                            <span class="font-bold text-slate-900 dark:text-white">{{ $summary['formatted_daily_rate'] }}</span>
                        </div>
                        <div class="mt-3 border-t border-slate-200 pt-3 flex items-center justify-between text-sm font-bold text-slate-900 dark:border-slate-700 dark:text-white">
                            <span>Total Final Charges:</span>
                            <span class="text-base text-emerald-600 dark:text-emerald-400">{{ $summary['formatted_final_amount'] }}</span>
                        </div>
                    </div>

                    <!-- Confirm Return Form -->
                    <form method="POST" action="{{ route('rentals.return.confirm') }}" class="mt-6">
                        @csrf
                        <input type="hidden" name="license_plate" value="{{ $verifiedRental->car->license_plate }}">
                        <button type="submit" class="w-full rounded-xl bg-emerald-600 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/25 transition-all hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            Confirm Return and Settle Invoice
                        </button>
                    </form>
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-slate-200 p-8 text-center dark:border-slate-800">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="mt-3 text-sm font-bold text-slate-900 dark:text-white">Awaiting Verification</h3>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Enter your vehicle license plate or pick an active rental on the left to review final billing.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
