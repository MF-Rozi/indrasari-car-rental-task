@extends('layouts.app')

@section('content')
<div class="space-y-6 py-2 sm:py-6">
    <!-- Top Actions -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between no-print">
        <a href="{{ route('rentals.my-rentals') }}" class="inline-flex items-center space-x-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50 dark:border-slate-800 dark:bg-[#1E293B] dark:text-slate-300 dark:hover:bg-slate-800">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back to My Rentals</span>
        </a>

        <div class="flex items-center space-x-3">
            <button type="button" onclick="window.print()" class="inline-flex items-center space-x-2 rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white shadow-sm shadow-blue-500/20 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Print / Download Receipt</span>
            </button>
        </div>
    </div>

    <!-- Printable Invoice Container -->
    <div class="printable-invoice overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 shadow-xl sm:p-12 dark:border-slate-800 dark:bg-[#1E293B]">
        <!-- Invoice Header -->
        <div class="flex flex-col gap-6 border-b border-slate-200 pb-8 sm:flex-row sm:items-start sm:justify-between dark:border-slate-800">
            <div class="flex items-center space-x-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-md">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-black tracking-tight text-slate-900 dark:text-white">Indrasari Car Rental</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Official Rental Invoice & Receipt</p>
                </div>
            </div>

            <div class="text-left sm:text-right">
                <div class="inline-flex items-center space-x-2 rounded-xl bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span class="uppercase tracking-wider">{{ $invoice->payment_status }}</span>
                </div>
                <p class="mt-2 font-mono text-sm font-bold text-slate-900 dark:text-white">{{ $invoice->invoice_number }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Issued: {{ $invoice->issued_at->format('d M Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- Billing & Rental Parties Info -->
        <div class="mt-8 grid grid-cols-1 gap-8 sm:grid-cols-2">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Billed To (Customer)</span>
                <div class="mt-2 space-y-1 text-xs text-slate-600 dark:text-slate-300">
                    <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $rental->user->name }}</p>
                    <p>{{ $rental->user->email }}</p>
                    <p>{{ $rental->user->phone_number ?? '-' }}</p>
                    <p><span class="font-semibold text-slate-400">SIM A:</span> <span class="font-mono font-bold text-slate-900 dark:text-white">{{ $rental->user->sim_number ?? '-' }}</span></p>
                    <p>{{ $rental->user->address ?? '-' }}</p>
                </div>
            </div>

            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Rental Trip Summary</span>
                <div class="mt-2 space-y-1 text-xs text-slate-600 dark:text-slate-300">
                    <p><span class="font-semibold text-slate-400">Booking Reference:</span> <span class="font-mono font-bold">#RENT-{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                    <p><span class="font-semibold text-slate-400">Pick-up Date:</span> {{ $rental->start_date->format('d M Y') }}</p>
                    <p><span class="font-semibold text-slate-400">Actual Return:</span> {{ $rental->actual_return_date ? $rental->actual_return_date->format('d M Y') : now()->format('d M Y') }}</p>
                    <p><span class="font-semibold text-slate-400">Total Duration:</span> {{ $rental->total_days }} {{ $rental->total_days > 1 ? 'Days' : 'Day' }}</p>
                </div>
            </div>
        </div>

        <!-- Vehicle Details & Charges Table -->
        <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-800">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 dark:bg-[#0F172A] dark:text-slate-400">
                    <tr>
                        <th class="px-5 py-3 font-semibold uppercase tracking-wider">Item / Vehicle Description</th>
                        <th class="px-5 py-3 font-semibold uppercase tracking-wider">Plate</th>
                        <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right">Daily Rate</th>
                        <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right">Duration</th>
                        <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right">Amount (IDR)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-800 dark:divide-slate-800 dark:text-slate-200">
                    <tr>
                        <td class="px-5 py-4">
                            <p class="font-bold text-slate-900 dark:text-white">{{ $rental->car->brand }} {{ $rental->car->model }}</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $rental->car->transmission }} &bull; {{ $rental->car->seating_capacity }} Seats</p>
                        </td>
                        <td class="px-5 py-4 font-mono font-bold">{{ $rental->car->license_plate }}</td>
                        <td class="px-5 py-4 text-right">{{ $rental->car->formatted_daily_rate }}</td>
                        <td class="px-5 py-4 text-right">{{ $rental->total_days }} {{ $rental->total_days > 1 ? 'Days' : 'Day' }}</td>
                        <td class="px-5 py-4 text-right font-bold">{{ $invoice->formatted_total_amount }}</td>
                    </tr>
                </tbody>
                <tfoot class="bg-slate-50/80 font-bold dark:bg-[#0F172A]/80">
                    <tr>
                        <td colspan="4" class="px-5 py-4 text-right text-slate-600 dark:text-slate-400">Total Paid Amount:</td>
                        <td class="px-5 py-4 text-right text-base text-emerald-600 dark:text-emerald-400">{{ $invoice->formatted_total_amount }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footer Thank You Note -->
        <div class="mt-8 border-t border-slate-200 pt-6 text-center text-xs text-slate-400 dark:border-slate-800">
            <p>Thank you for choosing Indrasari Car Rental for your journey. We hope to see you again soon!</p>
            <p class="mt-1 text-[11px] text-slate-400">Questions? Contact us at support@indrasari.test</p>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        nav, footer, .no-print {
            display: none !important;
        }
        body {
            background-color: white !important;
            color: black !important;
        }
        .printable-invoice {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            background-color: white !important;
            color: black !important;
        }
    }
</style>
@endpush
@endsection
