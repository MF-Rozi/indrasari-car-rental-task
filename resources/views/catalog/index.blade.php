@extends('layouts.app')

@section('content')
<div class="space-y-8 py-2 sm:py-6">
    <!-- Hero Banner -->
    <div class="relative overflow-hidden rounded-3xl border border-slate-200/80 bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-900 px-6 py-10 text-white shadow-xl sm:px-12 sm:py-14 dark:border-slate-800">
        <div class="relative z-10 max-w-2xl">
            <span class="inline-flex items-center rounded-lg bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider backdrop-blur-md">
                Verified Fleet & Best Daily Rates
            </span>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight sm:text-4xl lg:text-5xl">
                Find the Perfect Ride for Every Journey
            </h1>
            <p class="mt-3 text-sm text-blue-100 sm:text-base">
                Browse our premium fleet in Indonesia. Transparent pricing with no hidden fees, instant booking confirmation, and flexible returns.
            </p>
        </div>

        <!-- Decorative Glow Accents -->
        <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-blue-400/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-20 -left-20 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl"></div>
    </div>

    <!-- Search & Date Filter Bar -->
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6 dark:border-slate-800 dark:bg-[#1E293B]">
        <form method="GET" action="{{ route('catalog.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-12">
            <input type="hidden" name="brand" value="{{ $currentBrand }}">

            <!-- Keyword Search -->
            <div class="lg:col-span-4">
                <label for="search" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                    Search Vehicle
                </label>
                <div class="relative mt-1.5">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" id="search" name="search" value="{{ $currentSearch }}" placeholder="e.g. Avanza, HR-V, Ioniq..."
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500">
                </div>
            </div>

            <!-- Start Date -->
            <div class="lg:col-span-3">
                <label for="start_date" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                    Pick-up Date
                </label>
                <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" min="{{ date('Y-m-d') }}"
                    class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white">
            </div>

            <!-- End Date -->
            <div class="lg:col-span-3">
                <label for="end_date" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                    Return Date
                </label>
                <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" min="{{ date('Y-m-d') }}"
                    class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white">
            </div>

            <!-- Submit Filter Button -->
            <div class="flex items-end lg:col-span-2">
                <button type="submit" class="flex w-full items-center justify-center space-x-2 rounded-xl bg-blue-600 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Brand Pills & Sort Control -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <!-- Brand Pills -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('catalog.index', ['brand' => 'all', 'search' => $currentSearch, 'start_date' => $startDate, 'end_date' => $endDate, 'sort' => $currentSort]) }}"
                class="rounded-xl px-4 py-2 text-xs font-semibold transition-all {{ $currentBrand === 'all' || !$currentBrand ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800' }}">
                All Makes
            </a>
            @foreach($brands as $brandName)
                <a href="{{ route('catalog.index', ['brand' => $brandName, 'search' => $currentSearch, 'start_date' => $startDate, 'end_date' => $endDate, 'sort' => $currentSort]) }}"
                    class="rounded-xl px-4 py-2 text-xs font-semibold transition-all {{ $currentBrand === $brandName ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    {{ $brandName }}
                </a>
            @endforeach
        </div>

        <!-- Sort Dropdown -->
        <form method="GET" action="{{ route('catalog.index') }}" class="flex items-center space-x-2">
            <input type="hidden" name="brand" value="{{ $currentBrand }}">
            <input type="hidden" name="search" value="{{ $currentSearch }}">
            <input type="hidden" name="start_date" value="{{ $startDate }}">
            <input type="hidden" name="end_date" value="{{ $endDate }}">

            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Sort:</span>
            <select name="sort" onchange="this.form.submit()"
                class="rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 focus:border-blue-500 focus:outline-none dark:border-slate-700 dark:bg-[#1E293B] dark:text-slate-200">
                <option value="latest" {{ $currentSort === 'latest' ? 'selected' : '' }}>Featured / Latest</option>
                <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
        </form>
    </div>

    <!-- Vehicle Cards Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($cars as $car)
            <div class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md dark:border-slate-800 dark:bg-[#1E293B]">
                <!-- Vehicle Image -->
                <div class="relative h-48 w-full overflow-hidden bg-slate-100 dark:bg-slate-800">
                    @if($car->image_path)
                        <img src="{{ Storage::url($car->image_path) }}" alt="{{ $car->brand }} {{ $car->model }}"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-slate-400 dark:text-slate-500">
                            <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                            </svg>
                        </div>
                    @endif

                    <!-- Status Pill -->
                    <div class="absolute right-3 top-3">
                        @if($car->isAvailable())
                            <span class="inline-flex items-center rounded-xl bg-emerald-500/90 px-2.5 py-1 text-[11px] font-semibold text-white shadow-sm backdrop-blur-md">
                                Available Now
                            </span>
                        @elseif($car->isRented())
                            <span class="inline-flex items-center rounded-xl bg-sky-500/90 px-2.5 py-1 text-[11px] font-semibold text-white shadow-sm backdrop-blur-md">
                                Currently Rented
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-xl bg-amber-500/90 px-2.5 py-1 text-[11px] font-semibold text-white shadow-sm backdrop-blur-md">
                                Maintenance
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Card Body -->
                <div class="flex flex-1 flex-col p-5">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">{{ $car->brand }}</span>
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white">{{ $car->model }}</h2>
                        </div>
                        <span class="inline-flex shrink-0 items-center rounded-lg border border-slate-200 bg-slate-50 px-2 py-0.5 font-mono text-[11px] font-bold text-slate-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300">
                            {{ $car->license_plate }}
                        </span>
                    </div>

                    <!-- Specification Chips -->
                    <div class="mt-4 flex flex-wrap gap-2 text-xs text-slate-600 dark:text-slate-300">
                        <span class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 dark:bg-slate-800">
                            <svg class="mr-1.5 h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            {{ $car->transmission }}
                        </span>
                        <span class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 dark:bg-slate-800">
                            <svg class="mr-1.5 h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{ $car->seating_capacity }} Seats
                        </span>
                    </div>

                    <!-- Card Footer: Rate & Action Button -->
                    <div class="mt-6 flex items-center justify-between border-t border-slate-100 pt-4 dark:border-slate-800">
                        <div>
                            <span class="text-[11px] font-semibold text-slate-400">Daily Rate</span>
                            <p class="text-base font-bold text-blue-600 dark:text-blue-400">{{ $car->formatted_daily_rate }}</p>
                        </div>
                        <a href="{{ route('catalog.show', $car) }}" class="rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white shadow-sm transition-colors hover:bg-blue-700">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-slate-200 bg-white p-12 text-center shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-base font-bold text-slate-900 dark:text-white">No vehicles found</h3>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    No vehicles match your current filter parameters. Try clearing your search keyword or selected date range.
                </p>
                <div class="mt-6">
                    <a href="{{ route('catalog.index') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-blue-700">
                        Clear All Filters
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($cars->hasPages())
        <div class="pt-4">
            {{ $cars->links() }}
        </div>
    @endif
</div>
@endsection
