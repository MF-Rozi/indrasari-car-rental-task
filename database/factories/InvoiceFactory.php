<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Rental;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = fake()->numberBetween(1, 7) * 500000;
        $uniqueCode = strtoupper(fake()->bothify('INV-########-####'));

        return [
            'rental_id' => Rental::factory()->completed(),
            'invoice_number' => $uniqueCode,
            'total_amount' => $amount,
            'payment_status' => 'paid',
            'issued_at' => now(),
        ];
    }
}
