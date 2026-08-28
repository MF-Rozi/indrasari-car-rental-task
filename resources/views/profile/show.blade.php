@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-4xl py-4 sm:py-8">
    <!-- Header Banner -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-white">Account Profile</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                Manage your personal details, contact information, and security credentials.
            </p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="inline-flex items-center rounded-xl bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:bg-blue-950/60 dark:text-blue-300">
                Driver License: {{ $user->sim_number }}
            </span>
            @if($user->isAdmin())
                <span class="inline-flex items-center rounded-xl bg-purple-50 px-3 py-1.5 text-xs font-semibold text-purple-700 dark:bg-purple-950/60 dark:text-purple-300">
                    Administrator
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- User Overview Card -->
        <div class="lg:col-span-1">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-[#1E293B]">
                <div class="text-center">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-blue-600 text-2xl font-bold text-white shadow-lg shadow-blue-500/20">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h2 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">{{ $user->name }}</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                </div>

                <div class="mt-6 space-y-3 border-t border-slate-100 pt-6 dark:border-slate-700/60">
                    <div>
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Phone Number</span>
                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $user->phone_number }}</p>
                    </div>
                    <div>
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">License Number (SIM)</span>
                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $user->sim_number }}</p>
                    </div>
                    <div>
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Registered On</span>
                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile & Security Form -->
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Personal Information Card -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 dark:border-slate-800 dark:bg-[#1E293B]">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Personal Information</h2>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Update your identity and contact information used for rental verifications.</p>

                    <div class="mt-6 space-y-4">
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                Full Name <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:focus:border-blue-400 @error('name') border-rose-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number & SIM Number -->
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="phone_number" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                    Phone Number <span class="text-rose-500">*</span>
                                </label>
                                <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required
                                    class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:focus:border-blue-400 @error('phone_number') border-rose-500 @enderror">
                                @error('phone_number')
                                    <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="sim_number" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                    Driver's License (SIM) <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="sim_number" name="sim_number" value="{{ old('sim_number', $user->sim_number) }}" required
                                    class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:focus:border-blue-400 @error('sim_number') border-rose-500 @enderror">
                                @error('sim_number')
                                    <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                Physical Address <span class="text-rose-500">*</span>
                            </label>
                            <textarea id="address" name="address" rows="3" required
                                class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:focus:border-blue-400 @error('address') border-rose-500 @enderror">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password Update Card -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 dark:border-slate-800 dark:bg-[#1E293B]">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Change Password</h2>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Leave blank if you do not wish to change your password.</p>

                    <div class="mt-6 space-y-4">
                        <div>
                            <label for="current_password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                Current Password
                            </label>
                            <input type="password" id="current_password" name="current_password"
                                class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:focus:border-blue-400 @error('current_password') border-rose-500 @enderror"
                                placeholder="Enter current password to verify">
                            @error('current_password')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                    New Password
                                </label>
                                <input type="password" id="password" name="password"
                                    class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:focus:border-blue-400 @error('password') border-rose-500 @enderror"
                                    placeholder="Min. 8 characters">
                                @error('password')
                                    <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                    Confirm New Password
                                </label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-900 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-[#0F172A] dark:text-white dark:focus:border-blue-400"
                                    placeholder="Confirm new password">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
