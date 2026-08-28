@extends('layouts.app')

@section('content')
<div class="space-y-8 py-2 sm:py-6">
    <!-- Top Back Breadcrumb -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('catalog.index') }}" class="inline-flex items-center space-x-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back to Fleet Catalog</span>
        </a>
    </div>

    <!-- Main Grid: Specifications & Sticky Booking Estimator -->
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
        <!-- Left 8 Columns: Photos & Specs -->
        <div class="space-y-6 lg:col-span-8">
            <!-- Main Hero Image Container -->
            <div class="relative h-72 w-full overflow-hidden rounded-3xl border border-slate-200 bg-slate-100 sm:h-96 dark:border-slate-800 dark:bg-slate-800">
                @if($car->image_path)
                    <img src="{{ Storage::url($car->image_path) }}" alt="{{ $car->brand }} {{ $car->model }}" class="h-full w-full object-cover">
                @else
                    <div class="flex h-full w-full items-center justify-center text-slate-400 dark:text-slate-500">
                        <svg class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                        </svg>
                    </div>
                @endif

                <!-- Status Badge -->
                <div class="absolute right-4 top-4">
                    @if($car->isAvailable())
                        <span class="inline-flex items-center rounded-xl bg-emerald-500/95 px-3 py-1 text-xs font-semibold text-white shadow-md backdrop-blur-md">
                            Available for Reservation
                        </span>
                    @elseif($car->isRented())
                        <span class="inline-flex items-center rounded-xl bg-sky-500/95 px-3 py-1 text-xs font-semibold text-white shadow-md backdrop-blur-md">
                            Currently On Rent
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-xl bg-amber-500/95 px-3 py-1 text-xs font-semibold text-white shadow-md backdrop-blur-md">
                            Under Maintenance
                        </span>
                    @endif
                </div>
            </div>

            <!-- Vehicle Header & Highlights -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 dark:border-slate-800 dark:bg-[#1E293B]">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">{{ $car->brand }}</span>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-white">{{ $car->model }}</h1>
                    </div>
                    <span class="inline-flex items-center rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 font-mono text-sm font-bold text-slate-800 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                        {{ $car->license_plate }}
                    </span>
                </div>

                <!-- Technical Specs Grid -->
                <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-[#0F172A]">
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Transmission</span>
                        <p class="mt-1 text-sm font-bold text-slate-900 dark:text-white">{{ $car->transmission }}</p>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-[#0F172A]">
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Capacity</span>
                        <p class="mt-1 text-sm font-bold text-slate-900 dark:text-white">{{ $car->seating_capacity }} Passengers</p>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-[#0F172A]">
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Fuel & Type</span>
                        <p class="mt-1 text-sm font-bold text-slate-900 dark:text-white">Gasoline / Hybrid</p>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 dark:border-slate-800 dark:bg-[#0F172A]">
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Daily Rate</span>
                        <p class="mt-1 text-sm font-bold text-blue-600 dark:text-blue-400">{{ $car->formatted_daily_rate }}</p>
                    </div>
                </div>

                <!-- Rental Inclusions -->
                <div class="mt-8 border-t border-slate-100 pt-6 dark:border-slate-800">
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Rental Inclusions & Benefits</h2>
                    <ul class="mt-3 grid grid-cols-1 gap-2 text-xs text-slate-600 sm:grid-cols-2 dark:text-slate-300">
                        <li class="flex items-center space-x-2">
                            <svg class="h-4 w-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Comprehensive Vehicle Insurance Coverage</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="h-4 w-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>24/7 Roadside Emergency Assistance</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="h-4 w-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Sanitized & Clean Vehicle Delivery</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="h-4 w-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Flexible Easy Returns by License Plate</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Related Vehicle Recommendations -->
            @if($relatedCars->isNotEmpty())
                <div class="space-y-4 pt-4">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Similar Vehicles You May Like</h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        @foreach($relatedCars as $related)
                            <a href="{{ route('catalog.show', $related) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:shadow-md dark:border-slate-800 dark:bg-[#1E293B]">
                                <div class="h-28 w-full overflow-hidden rounded-xl bg-slate-100 dark:bg-slate-800">
                                    @if($related->image_path)
                                        <img src="{{ Storage::url($related->image_path) }}" alt="{{ $related->brand }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-slate-400">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="mt-3 text-xs font-bold text-slate-900 dark:text-white truncate">{{ $related->brand }} {{ $related->model }}</h3>
                                <p class="mt-1 text-xs font-bold text-blue-600 dark:text-blue-400">{{ $related->formatted_daily_rate }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Right 4 Columns: Sticky Booking Price Estimator -->
        <div class="lg:col-span-4">
            <div class="sticky top-24 rounded-3xl border border-slate-200 bg-white p-6 shadow-xl dark:border-slate-800 dark:bg-[#1E293B]">
                <div class="border-b border-slate-100 pb-5 dark:border-slate-800">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pricing Summary</span>
                    <div class="mt-1 flex items-baseline space-x-2">
                        <span class="text-2xl font-black text-slate-900 dark:text-white">Rp {{ number_format($car->daily_rate, 0, ',', '.') }}</span>
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">/ 24 hours</span>
                    </div>
                </div>

                <!-- Live Estimator Form -->
                <form id="reservation-form" method="GET" action="{{ route('rentals.checkout', $car->id ?? 1) }}" class="mt-6 space-y-4">
                    <div>
                        <label for="book_start_date" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Start Date <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" id="book_start_date" name="start_date" value="{{ request('start_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required onchange="calculateRentalTotal()"
                            class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white">
                    </div>

                    <div>
                        <label for="book_end_date" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            End Date <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" id="book_end_date" name="end_date" value="{{ request('end_date', date('Y-m-d', strtotime('+2 days'))) }}" min="{{ date('Y-m-d') }}" required onchange="calculateRentalTotal()"
                            class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white">
                    </div>

                    <!-- Calculation Breakdown Box -->
                    <div class="mt-4 rounded-2xl border border-slate-100 bg-slate-50/80 p-4 dark:border-slate-800 dark:bg-[#0F172A]">
                        <div class="flex items-center justify-between text-xs text-slate-600 dark:text-slate-400">
                            <span>Duration:</span>
                            <span id="rental-days-display" class="font-bold text-slate-900 dark:text-white">2 Days</span>
                        </div>
                        <div class="mt-2 flex items-center justify-between text-xs text-slate-600 dark:text-slate-400">
                            <span>Base Rate:</span>
                            <span>Rp {{ number_format($car->daily_rate, 0, ',', '.') }} / day</span>
                        </div>
                        <div class="mt-3 border-t border-slate-200 pt-3 flex items-center justify-between text-sm font-bold text-slate-900 dark:border-slate-700 dark:text-white">
                            <span>Estimated Total:</span>
                            <span id="rental-total-display" class="text-base text-blue-600 dark:text-blue-400">Rp {{ number_format($car->daily_rate * 2, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-2">
                        @if($car->isAvailable())
                            <button type="submit" class="w-full rounded-xl bg-blue-600 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Proceed to Booking
                            </button>
                        @else
                            <button type="button" disabled class="w-full cursor-not-allowed rounded-xl bg-slate-200 py-3 text-sm font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                Vehicle Unavailable
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const dailyRate = {{ $car->daily_rate }};

    function calculateRentalTotal() {
        const startVal = document.getElementById('book_start_date').value;
        const endVal = document.getElementById('book_end_date').value;

        if (startVal && endVal) {
            const start = new Date(startVal);
            const end = new Date(endVal);

            const diffTime = end.getTime() - start.getTime();
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays < 1) {
                diffDays = 1;
            }

            const total = diffDays * dailyRate;

            document.getElementById('rental-days-display').innerText = `${diffDays} Day${diffDays > 1 ? 's' : ''}`;
            document.getElementById('rental-total-display').innerText = `Rp ${total.toLocaleString('id-ID')}`;
        }
    }

    document.addEventListener('DOMContentLoaded', calculateRentalTotal);
</script>
@endpush
@endsection
