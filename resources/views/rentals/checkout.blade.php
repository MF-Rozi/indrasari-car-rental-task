@extends('layouts.app')

@section('content')
<div class="space-y-8 py-2 sm:py-6">
    <!-- Breadcrumbs -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('catalog.show', $car) }}" class="inline-flex items-center space-x-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back to {{ $car->brand }} {{ $car->model }}</span>
        </a>
    </div>

    <!-- Page Title -->
    <div>
        <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">Step 2 of 2</span>
        <h1 class="mt-1 text-2xl font-black tracking-tight text-slate-900 sm:text-3xl dark:text-white">Review and Confirm Reservation</h1>
        <p class="mt-1 text-xs text-slate-500 sm:text-sm dark:text-slate-400">
            Please verify your rental period and driver details before confirming your reservation.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
        <!-- Left 8 Columns: Driver Details & Vehicle Info -->
        <div class="space-y-6 lg:col-span-8">
            <!-- Driver Profile Card -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7 dark:border-slate-800 dark:bg-[#1E293B]">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
                    <div class="flex items-center space-x-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white">Driver Information</h2>
                    </div>
                    <a href="{{ route('profile.show') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                        Edit Profile
                    </a>
                </div>

                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 text-xs">
                    <div>
                        <span class="font-semibold text-slate-400">Full Name</span>
                        <p class="mt-1 font-bold text-slate-900 dark:text-white">{{ $user->name }}</p>
                    </div>

                    <div>
                        <span class="font-semibold text-slate-400">Email Address</span>
                        <p class="mt-1 font-bold text-slate-900 dark:text-white">{{ $user->email }}</p>
                    </div>

                    <div>
                        <span class="font-semibold text-slate-400">Phone Number</span>
                        <p class="mt-1 font-bold text-slate-900 dark:text-white">{{ $user->phone_number ?? '-' }}</p>
                    </div>

                    <div>
                        <span class="font-semibold text-slate-400">Driving License (SIM A)</span>
                        <p class="mt-1 font-mono font-bold text-slate-900 dark:text-white">{{ $user->sim_number ?? '-' }}</p>
                    </div>

                    <div class="sm:col-span-2">
                        <span class="font-semibold text-slate-400">Residential Address</span>
                        <p class="mt-1 font-bold text-slate-900 dark:text-white">{{ $user->address ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Selected Vehicle Summary -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7 dark:border-slate-800 dark:bg-[#1E293B]">
                <div class="flex items-center space-x-3 border-b border-slate-100 pb-4 dark:border-slate-800">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                        </svg>
                    </div>
                    <h2 class="text-base font-bold text-slate-900 dark:text-white">Selected Vehicle</h2>
                </div>

                <div class="mt-5 flex flex-col gap-5 sm:flex-row sm:items-center">
                    <div class="h-32 w-full shrink-0 overflow-hidden rounded-xl bg-slate-100 sm:w-48 dark:bg-slate-800">
                        @if($car->image_path)
                            <img src="{{ Storage::url($car->image_path) }}" alt="{{ $car->brand }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-slate-400">
                                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">{{ $car->brand }}</span>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ $car->model }}</h3>
                        <div class="flex flex-wrap items-center gap-2 pt-1 text-xs text-slate-600 dark:text-slate-300">
                            <span class="rounded-lg bg-slate-100 px-2.5 py-1 font-mono font-bold dark:bg-slate-800">{{ $car->license_plate }}</span>
                            <span class="rounded-lg bg-slate-100 px-2.5 py-1 dark:bg-slate-800">{{ $car->transmission }}</span>
                            <span class="rounded-lg bg-slate-100 px-2.5 py-1 dark:bg-slate-800">{{ $car->seating_capacity }} Seats</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right 4 Columns: Sticky Price Summary & Submit -->
        <div class="lg:col-span-4">
            <div class="sticky top-24 rounded-3xl border border-slate-200 bg-white p-6 shadow-xl dark:border-slate-800 dark:bg-[#1E293B]">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Rental Schedule</h2>

                <form id="checkout-form" method="POST" action="{{ route('rentals.store') }}" class="mt-5 space-y-4">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">

                    <div>
                        <label for="start_date" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Pick-up Date <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $startDate) }}" min="{{ date('Y-m-d') }}" required onchange="calculateRentalTotal()"
                            class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white @error('start_date') border-rose-500 @enderror">
                        @error('start_date')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Return Date <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $endDate) }}" min="{{ date('Y-m-d') }}" required onchange="calculateRentalTotal()"
                            class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white @error('end_date') border-rose-500 @enderror">
                        @error('end_date')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cost Breakdown Box -->
                    <div class="mt-6 rounded-2xl border border-slate-100 bg-slate-50/80 p-4 dark:border-slate-800 dark:bg-[#0F172A]">
                        <div class="flex items-center justify-between text-xs text-slate-600 dark:text-slate-400">
                            <span>Duration:</span>
                            <span id="duration-display" class="font-bold text-slate-900 dark:text-white">3 Days</span>
                        </div>
                        <div class="mt-2 flex items-center justify-between text-xs text-slate-600 dark:text-slate-400">
                            <span>Daily Base Rate:</span>
                            <span>Rp {{ number_format($car->daily_rate, 0, ',', '.') }}</span>
                        </div>
                        <div class="mt-3 border-t border-slate-200 pt-3 flex items-center justify-between text-sm font-bold text-slate-900 dark:border-slate-700 dark:text-white">
                            <span>Estimated Total:</span>
                            <span id="total-display" class="text-base text-blue-600 dark:text-blue-400">Rp {{ number_format($car->daily_rate * 3, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Confirm Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full rounded-xl bg-blue-600 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Confirm Reservation
                        </button>
                    </div>

                    <p class="text-center text-[11px] text-slate-400 dark:text-slate-500">
                        Payment & final invoicing will be settled upon vehicle return.
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const dailyRate = {{ $car->daily_rate }};

    function calculateRentalTotal() {
        const startVal = document.getElementById('start_date').value;
        const endVal = document.getElementById('end_date').value;

        if (startVal && endVal) {
            const start = new Date(startVal);
            const end = new Date(endVal);

            const diffTime = end.getTime() - start.getTime();
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

            if (diffDays < 1) {
                diffDays = 1;
            }

            const total = diffDays * dailyRate;

            document.getElementById('duration-display').innerText = `${diffDays} Day${diffDays > 1 ? 's' : ''}`;
            document.getElementById('total-display').innerText = `Rp ${total.toLocaleString('id-ID')}`;
        }
    }

    document.addEventListener('DOMContentLoaded', calculateRentalTotal);
</script>
@endpush
@endsection
