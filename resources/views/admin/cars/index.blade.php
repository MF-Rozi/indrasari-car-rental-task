@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-white">Fleet Management</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                Manage, audit, and configure vehicle specifications, daily rental rates, and operational availability.
            </p>
        </div>
        <div>
            <a href="{{ route('admin.cars.create') }}" class="inline-flex items-center space-x-2 rounded-xl bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-purple-500/25 transition-all hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Add New Vehicle</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between dark:border-slate-800 dark:bg-[#1E293B]">
        <!-- Search Input -->
        <form method="GET" action="{{ route('admin.cars.index') }}" class="relative flex-1 sm:max-w-md">
            <input type="hidden" name="status" value="{{ $currentStatus }}">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ $currentSearch }}" placeholder="Search by brand, model, or plate..."
                class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-400 focus:border-purple-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500 dark:focus:border-purple-400">
        </form>

        <!-- Status Filter Pills -->
        <div class="flex flex-wrap items-center gap-1.5">
            <a href="{{ route('admin.cars.index', ['search' => $currentSearch, 'status' => 'all']) }}"
                class="rounded-xl px-3 py-1.5 text-xs font-semibold transition-colors {{ $currentStatus === 'all' || !$currentStatus ? 'bg-purple-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                All ({{ \App\Models\Car::count() }})
            </a>
            <a href="{{ route('admin.cars.index', ['search' => $currentSearch, 'status' => 'available']) }}"
                class="rounded-xl px-3 py-1.5 text-xs font-semibold transition-colors {{ $currentStatus === 'available' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-950/50 dark:text-emerald-300 dark:hover:bg-emerald-900/50' }}">
                Available
            </a>
            <a href="{{ route('admin.cars.index', ['search' => $currentSearch, 'status' => 'rented']) }}"
                class="rounded-xl px-3 py-1.5 text-xs font-semibold transition-colors {{ $currentStatus === 'rented' ? 'bg-sky-600 text-white shadow-sm' : 'bg-sky-50 text-sky-700 hover:bg-sky-100 dark:bg-sky-950/50 dark:text-sky-300 dark:hover:bg-sky-900/50' }}">
                Rented
            </a>
            <a href="{{ route('admin.cars.index', ['search' => $currentSearch, 'status' => 'maintenance']) }}"
                class="rounded-xl px-3 py-1.5 text-xs font-semibold transition-colors {{ $currentStatus === 'maintenance' ? 'bg-amber-600 text-white shadow-sm' : 'bg-amber-50 text-amber-700 hover:bg-amber-100 dark:bg-amber-950/50 dark:text-amber-300 dark:hover:bg-amber-900/50' }}">
                Maintenance
            </a>
        </div>
    </div>

    <!-- Fleet Inventory Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50/75 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-[#0F172A] dark:text-slate-400">
                    <tr>
                        <th class="px-6 py-3.5">Vehicle</th>
                        <th class="px-6 py-3.5">License Plate</th>
                        <th class="px-6 py-3.5">Daily Rate</th>
                        <th class="px-6 py-3.5">Specs</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                    @forelse($cars as $car)
                        <tr class="transition-colors hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <!-- Vehicle Brand & Model -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3.5">
                                    <div class="h-12 w-16 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-slate-100 dark:border-slate-700 dark:bg-slate-800">
                                        @if($car->image_path)
                                            <img src="{{ Storage::url($car->image_path) }}" alt="{{ $car->brand }} {{ $car->model }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-slate-400 dark:text-slate-500">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 dark:text-white">{{ $car->brand }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $car->model }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- License Plate -->
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1 font-mono text-xs font-bold text-slate-800 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                                    {{ $car->license_plate }}
                                </span>
                            </td>

                            <!-- Daily Rate -->
                            <td class="px-6 py-4">
                                <span class="font-semibold text-purple-600 dark:text-purple-400">
                                    {{ $car->formatted_daily_rate }}
                                </span>
                            </td>

                            <!-- Specs -->
                            <td class="px-6 py-4 text-xs text-slate-600 dark:text-slate-300">
                                <div class="space-y-0.5">
                                    <p>{{ $car->transmission }}</p>
                                    <p class="text-slate-400 dark:text-slate-500">{{ $car->seating_capacity }} Seats</p>
                                </div>
                            </td>

                            <!-- Status Badge -->
                            <td class="px-6 py-4">
                                @if($car->status === 'available')
                                    <span class="inline-flex items-center rounded-xl border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Available
                                    </span>
                                @elseif($car->status === 'rented')
                                    <span class="inline-flex items-center rounded-xl border border-sky-200 bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700 dark:border-sky-800 dark:bg-sky-950/60 dark:text-sky-300">
                                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-sky-500"></span>
                                        Rented
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-xl border border-amber-200 bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:border-amber-800 dark:bg-amber-950/60 dark:text-amber-300">
                                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        Maintenance
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.cars.edit', $car) }}" class="rounded-lg border border-slate-200 p-1.5 text-slate-600 hover:bg-slate-100 hover:text-purple-600 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-purple-400" title="Edit Vehicle">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <button type="button" onclick="openDeleteModal('{{ route('admin.cars.destroy', $car) }}', '{{ $car->brand }} {{ $car->model }} ({{ $car->license_plate }})')" class="rounded-lg border border-slate-200 p-1.5 text-slate-600 hover:bg-rose-50 hover:text-rose-600 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-rose-950/40 dark:hover:text-rose-400" title="Delete Vehicle">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                                    </svg>
                                </div>
                                <h3 class="mt-3 text-sm font-semibold text-slate-900 dark:text-white">No vehicles found</h3>
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                    Try adjusting your search keyword or status filter.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($cars->hasPages())
            <div class="border-t border-slate-200 px-6 py-4 dark:border-slate-800">
                {{ $cars->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
    <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-800 dark:bg-[#1E293B]">
        <div class="flex items-center space-x-3 text-rose-600 dark:text-rose-400">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-100 dark:bg-rose-950/60">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Confirm Removal</h3>
        </div>

        <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
            Are you sure you want to remove <span id="delete-car-name" class="font-semibold text-slate-900 dark:text-white"></span> from the fleet?
        </p>

        <form id="delete-form" method="POST" action="" class="mt-6 flex justify-end space-x-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                Cancel
            </button>
            <button type="submit" class="rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-rose-500/25 hover:bg-rose-700">
                Delete Vehicle
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openDeleteModal(actionUrl, carName) {
        document.getElementById('delete-form').action = actionUrl;
        document.getElementById('delete-car-name').innerText = carName;
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endpush
@endsection
