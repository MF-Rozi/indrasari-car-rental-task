@extends('layouts.app')

@section('content')
<div class="space-y-8 py-2 sm:py-6">
    <!-- Header with Action -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900 sm:text-3xl dark:text-white">My Rentals and Reservations</h1>
            <p class="mt-1 text-xs text-slate-500 sm:text-sm dark:text-slate-400">
                Track your active vehicle rentals, manage upcoming bookings, and view completed trips.
            </p>
        </div>
        <a href="{{ route('catalog.index') }}" class="inline-flex items-center space-x-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-semibold text-white shadow-sm shadow-blue-500/20 hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Book Another Car</span>
        </a>
    </div>

    <!-- Status Navigation Filter Tabs -->
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-4 dark:border-slate-800">
        <a href="{{ route('rentals.my-rentals', ['status' => 'all']) }}"
            class="inline-flex items-center space-x-2 rounded-xl px-4 py-2 text-xs font-semibold transition-all {{ $currentStatus === 'all' ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800' }}">
            <span>All Bookings</span>
            <span class="rounded-full px-2 py-0.5 text-[10px] {{ $currentStatus === 'all' ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">{{ $allCount }}</span>
        </a>

        <a href="{{ route('rentals.my-rentals', ['status' => 'active']) }}"
            class="inline-flex items-center space-x-2 rounded-xl px-4 py-2 text-xs font-semibold transition-all {{ $currentStatus === 'active' ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800' }}">
            <span>Active Ongoing</span>
            <span class="rounded-full px-2 py-0.5 text-[10px] {{ $currentStatus === 'active' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300' }}">{{ $activeCount }}</span>
        </a>

        <a href="{{ route('rentals.my-rentals', ['status' => 'upcoming']) }}"
            class="inline-flex items-center space-x-2 rounded-xl px-4 py-2 text-xs font-semibold transition-all {{ $currentStatus === 'upcoming' ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800' }}">
            <span>Upcoming</span>
            <span class="rounded-full px-2 py-0.5 text-[10px] {{ $currentStatus === 'upcoming' ? 'bg-white/20 text-white' : 'bg-sky-100 text-sky-700 dark:bg-sky-950/60 dark:text-sky-300' }}">{{ $upcomingCount }}</span>
        </a>

        <a href="{{ route('rentals.my-rentals', ['status' => 'completed']) }}"
            class="inline-flex items-center space-x-2 rounded-xl px-4 py-2 text-xs font-semibold transition-all {{ $currentStatus === 'completed' ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800' }}">
            <span>Completed</span>
            <span class="rounded-full px-2 py-0.5 text-[10px] {{ $currentStatus === 'completed' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400' }}">{{ $completedCount }}</span>
        </a>

        <a href="{{ route('rentals.my-rentals', ['status' => 'cancelled']) }}"
            class="inline-flex items-center space-x-2 rounded-xl px-4 py-2 text-xs font-semibold transition-all {{ $currentStatus === 'cancelled' ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800' }}">
            <span>Cancelled</span>
            <span class="rounded-full px-2 py-0.5 text-[10px] {{ $currentStatus === 'cancelled' ? 'bg-white/20 text-white' : 'bg-rose-100 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300' }}">{{ $cancelledCount }}</span>
        </a>
    </div>

    <!-- Rentals Cards Grid -->
    <div class="space-y-4">
        @forelse($rentals as $rental)
            <div class="flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all sm:flex-row sm:items-center sm:justify-between sm:p-6 dark:border-slate-800 dark:bg-[#1E293B]">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                    <!-- Vehicle Thumbnail -->
                    <div class="h-24 w-full shrink-0 overflow-hidden rounded-xl bg-slate-100 sm:h-24 sm:w-36 dark:bg-slate-800">
                        @if($rental->car->image_path)
                            <img src="{{ Storage::url($rental->car->image_path) }}" alt="{{ $rental->car->brand }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-slate-400">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Rental & Car Details -->
                    <div class="space-y-1.5">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">{{ $rental->car->brand }}</span>
                            <span class="font-mono text-xs font-bold text-slate-700 dark:text-slate-300">[{{ $rental->car->license_plate }}]</span>
                            
                            <!-- Status Badges -->
                            @if($rental->isActive())
                                <span class="rounded-xl border border-emerald-200 bg-emerald-50 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                    Active Ongoing
                                </span>
                            @elseif($rental->isUpcoming())
                                <span class="rounded-xl border border-sky-200 bg-sky-50 px-2.5 py-0.5 text-[11px] font-bold text-sky-700 dark:border-sky-800 dark:bg-sky-950/60 dark:text-sky-300">
                                    Upcoming
                                </span>
                            @elseif($rental->isCompleted())
                                <span class="rounded-xl border border-slate-200 bg-slate-100 px-2.5 py-0.5 text-[11px] font-bold text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                    Completed
                                </span>
                            @else
                                <span class="rounded-xl border border-rose-200 bg-rose-50 px-2.5 py-0.5 text-[11px] font-bold text-rose-700 dark:border-rose-800 dark:bg-rose-950/60 dark:text-rose-300">
                                    Cancelled
                                </span>
                            @endif
                        </div>

                        <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ $rental->car->model }}</h3>

                        <!-- Dates & Duration -->
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 dark:text-slate-400">
                            <div class="flex items-center space-x-1.5">
                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $rental->start_date->format('d M Y') }} &rarr; {{ $rental->end_date->format('d M Y') }}</span>
                            </div>
                            <span>({{ $rental->total_days }} {{ $rental->total_days > 1 ? 'Days' : 'Day' }})</span>
                        </div>
                    </div>
                </div>

                <!-- Price & Contextual Action Buttons -->
                <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-4 sm:mt-0 sm:flex-col sm:items-end sm:border-0 sm:pt-0 dark:border-slate-800">
                    <div class="text-left sm:text-right">
                        <span class="text-[11px] font-semibold text-slate-400">
                            {{ $rental->isCompleted() ? 'Final Settled Price' : 'Estimated Price' }}
                        </span>
                        <p class="text-base font-bold text-blue-600 dark:text-blue-400">
                            {{ $rental->isCompleted() && $rental->formatted_final_price ? $rental->formatted_final_price : $rental->formatted_estimated_price }}
                        </p>
                    </div>

                    <div class="mt-2 flex items-center space-x-2">
                        @if($rental->isActive())
                            <a href="{{ route('rentals.return', ['license_plate' => $rental->car->license_plate]) }}"
                                class="inline-flex items-center space-x-1.5 rounded-xl bg-emerald-600 px-3.5 py-2 text-xs font-semibold text-white shadow-sm shadow-emerald-500/20 hover:bg-emerald-700">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <span>Return Vehicle</span>
                            </a>
                        @elseif($rental->isUpcoming())
                            <button type="button"
                                onclick="openCancelModal('{{ route('rentals.cancel', $rental) }}', '{{ $rental->car->brand }} {{ $rental->car->model }} ({{ $rental->start_date->format('d M Y') }})')"
                                class="inline-flex items-center space-x-1 rounded-xl border border-rose-200 bg-rose-50 px-3.5 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-100 dark:border-rose-900/60 dark:bg-rose-950/40 dark:text-rose-300 dark:hover:bg-rose-900/50">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span>Cancel Booking</span>
                            </button>
                        @elseif($rental->isCompleted())
                            <a href="{{ route('catalog.show', $rental->car) }}"
                                class="rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                Rent Again
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-slate-200 bg-white p-12 text-center shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                    </svg>
                </div>
                <h2 class="mt-4 text-base font-bold text-slate-900 dark:text-white">No reservations found</h2>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    You do not have any vehicle reservations in this category yet.
                </p>
                <div class="mt-6">
                    <a href="{{ route('catalog.index') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-semibold text-white shadow-sm hover:bg-blue-700">
                        Explore Available Fleet
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($rentals->hasPages())
        <div class="pt-4">
            {{ $rentals->links() }}
        </div>
    @endif
</div>

<!-- Cancellation Confirmation Modal -->
<div id="cancel-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
    <div class="w-full max-w-md overflow-hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-800 dark:bg-[#1E293B]">
        <div class="flex items-center space-x-3 text-rose-600 dark:text-rose-400">
            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-rose-50 dark:bg-rose-950/60">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Cancel Reservation</h3>
        </div>

        <p id="cancel-modal-description" class="mt-3 text-xs text-slate-600 dark:text-slate-300">
            Are you sure you want to cancel this booking? The reserved date window will be immediately released for other customers.
        </p>

        <form id="cancel-modal-form" method="POST" action="" class="mt-6 flex items-center justify-end space-x-3">
            @csrf
            <button type="button" onclick="closeCancelModal()" class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                Keep Booking
            </button>
            <button type="submit" class="rounded-xl bg-rose-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500">
                Confirm Cancellation
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openCancelModal(actionUrl, bookingDescription) {
        const modal = document.getElementById('cancel-modal');
        const form = document.getElementById('cancel-modal-form');
        const desc = document.getElementById('cancel-modal-description');

        form.action = actionUrl;
        desc.innerText = `Are you sure you want to cancel your reservation for ${bookingDescription}? The dates will be released immediately.`;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeCancelModal() {
        const modal = document.getElementById('cancel-modal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
@endpush
@endsection
