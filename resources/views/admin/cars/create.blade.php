@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.cars.index') }}" class="rounded-xl border border-slate-200 p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900 dark:border-slate-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white" title="Back to Fleet List">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-white">Add New Vehicle</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">Register a new car into the rental fleet catalog.</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 dark:border-slate-800 dark:bg-[#1E293B]">
        <form method="POST" action="{{ route('admin.cars.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: General Info -->
            <div>
                <h2 class="text-base font-bold text-slate-900 dark:text-white">1. General Information</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Specify make, model, and vehicle registration identifier.</p>

                <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div>
                        <label for="brand" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Brand / Make <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="brand" name="brand" value="{{ old('brand') }}" required autofocus placeholder="e.g. Toyota"
                            class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-purple-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500 @error('brand') border-rose-500 @enderror">
                        @error('brand')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="model" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Model & Variant <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="model" name="model" value="{{ old('model') }}" required placeholder="e.g. Avanza 1.5 G TSS"
                            class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:border-purple-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500 @error('model') border-rose-500 @enderror">
                        @error('model')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="license_plate" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            License Plate (Nomor Polisi) <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="license_plate" name="license_plate" value="{{ old('license_plate') }}" required placeholder="e.g. B 1234 ABC"
                            class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 font-mono text-sm font-bold uppercase text-slate-900 placeholder-slate-400 focus:border-purple-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:placeholder-slate-500 @error('license_plate') border-rose-500 @enderror">
                        @error('license_plate')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 dark:border-slate-800"></div>

            <!-- Section 2: Pricing & Specifications -->
            <div>
                <h2 class="text-base font-bold text-slate-900 dark:text-white">2. Specifications & Pricing</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Configure transmission type, passenger capacity, daily rental rate, and operational status.</p>

                <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label for="daily_rate" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Daily Rate (IDR) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative mt-1.5">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-xs font-semibold text-slate-500 dark:text-slate-400">Rp</span>
                            <input type="number" id="daily_rate" name="daily_rate" value="{{ old('daily_rate', 450000) }}" step="10000" min="10000" required
                                class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm font-semibold text-slate-900 focus:border-purple-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white @error('daily_rate') border-rose-500 @enderror">
                        </div>
                        @error('daily_rate')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="transmission" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Transmission <span class="text-rose-500">*</span>
                        </label>
                        <select id="transmission" name="transmission" required
                            class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 focus:border-purple-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white @error('transmission') border-rose-500 @enderror">
                            <option value="Automatic" class="bg-white text-slate-900 dark:bg-[#0F172A] dark:text-slate-100" {{ old('transmission') === 'Automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="Manual" class="bg-white text-slate-900 dark:bg-[#0F172A] dark:text-slate-100" {{ old('transmission') === 'Manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                        @error('transmission')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="seating_capacity" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Seating Capacity <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" id="seating_capacity" name="seating_capacity" value="{{ old('seating_capacity', 5) }}" min="1" max="20" required
                            class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 focus:border-purple-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white @error('seating_capacity') border-rose-500 @enderror">
                        @error('seating_capacity')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Operational Status <span class="text-rose-500">*</span>
                        </label>
                        <select id="status" name="status" required
                            class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 focus:border-purple-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white @error('status') border-rose-500 @enderror">
                            <option value="available" class="bg-white text-slate-900 dark:bg-[#0F172A] dark:text-slate-100" {{ old('status', 'available') === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="rented" class="bg-white text-slate-900 dark:bg-[#0F172A] dark:text-slate-100" {{ old('status') === 'rented' ? 'selected' : '' }}>Rented</option>
                            <option value="maintenance" class="bg-white text-slate-900 dark:bg-[#0F172A] dark:text-slate-100" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 dark:border-slate-800"></div>

            <!-- Section 3: Vehicle Photo Upload -->
            <div>
                <h2 class="text-base font-bold text-slate-900 dark:text-white">3. Vehicle Photo</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Upload a crisp photo for display in customer catalog cards (JPEG, PNG, WebP up to 2MB).</p>

                <div class="mt-4 flex flex-col gap-6 sm:flex-row sm:items-center">
                    <!-- Live Image Preview Box -->
                    <div id="image-preview-container" class="flex h-36 w-48 shrink-0 items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 dark:border-slate-700 dark:bg-[#0F172A]">
                        <img id="image-preview" src="#" alt="Preview" class="hidden h-full w-full object-cover">
                        <div id="image-preview-placeholder" class="text-center p-3">
                            <svg class="mx-auto h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="mt-1 block text-[11px] text-slate-400">No image chosen</span>
                        </div>
                    </div>

                    <div class="flex-1">
                        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewSelectedImage(this)"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:rounded-xl file:border-0 file:bg-purple-50 file:px-4 file:py-2.5 file:text-xs file:font-semibold file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-purple-950/60 dark:file:text-purple-300 @error('image') text-rose-500 @enderror">
                        @error('image')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 border-t border-slate-100 pt-6 dark:border-slate-800">
                <a href="{{ route('admin.cars.index') }}" class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                    Cancel
                </a>
                <button type="submit" class="rounded-xl bg-purple-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-purple-500/25 transition-all hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    Save Vehicle
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewSelectedImage(input) {
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('image-preview-placeholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }
</script>
@endpush
@endsection
