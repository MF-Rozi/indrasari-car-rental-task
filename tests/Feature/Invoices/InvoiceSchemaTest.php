<?php

use App\Models\Invoice;
use App\Models\Rental;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('invoice record can be created with valid rental relationship', function () {
    $rental = Rental::factory()->completed()->create([
        'final_price' => 1500000,
    ]);

    $invoice = Invoice::create([
        'rental_id' => $rental->id,
        'invoice_number' => 'INV-20260901-0001',
        'total_amount' => 1500000,
        'payment_status' => 'paid',
        'issued_at' => now(),
    ]);

    expect($invoice->rental->id)->toBe($rental->id)
        ->and($rental->invoice->id)->toBe($invoice->id)
        ->and($invoice->isPaid())->toBeTrue()
        ->and($invoice->formatted_total_amount)->toBe('Rp 1.500.000');
});
