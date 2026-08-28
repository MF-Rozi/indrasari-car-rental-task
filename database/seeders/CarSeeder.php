<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fleet = [
            [
                'brand' => 'Toyota',
                'model' => 'Avanza 1.5 G TSS',
                'license_plate' => 'B 1024 TYA',
                'daily_rate' => 450000,
                'transmission' => 'Automatic',
                'seating_capacity' => 7,
                'status' => 'available',
            ],
            [
                'brand' => 'Toyota',
                'model' => 'Innova Zenix 2.0 V Hybrid',
                'license_plate' => 'B 2345 INZ',
                'daily_rate' => 850000,
                'transmission' => 'Automatic',
                'seating_capacity' => 7,
                'status' => 'available',
            ],
            [
                'brand' => 'Toyota',
                'model' => 'Fortuner 2.8 GR Sport 4x4',
                'license_plate' => 'B 8888 FTR',
                'daily_rate' => 1250000,
                'transmission' => 'Automatic',
                'seating_capacity' => 7,
                'status' => 'available',
            ],
            [
                'brand' => 'Honda',
                'model' => 'Brio RS Urbanite',
                'license_plate' => 'B 1984 HBR',
                'daily_rate' => 350000,
                'transmission' => 'Automatic',
                'seating_capacity' => 5,
                'status' => 'available',
            ],
            [
                'brand' => 'Honda',
                'model' => 'HR-V 1.5 SE',
                'license_plate' => 'B 5566 HRV',
                'daily_rate' => 650000,
                'transmission' => 'Automatic',
                'seating_capacity' => 5,
                'status' => 'available',
            ],
            [
                'brand' => 'Honda',
                'model' => 'CR-V 1.5 Turbo Prestige',
                'license_plate' => 'B 7788 CRV',
                'daily_rate' => 950000,
                'transmission' => 'Automatic',
                'seating_capacity' => 7,
                'status' => 'available',
            ],
            [
                'brand' => 'Mitsubishi',
                'model' => 'Xpander Cross Premium',
                'license_plate' => 'B 3456 MIT',
                'daily_rate' => 500000,
                'transmission' => 'Automatic',
                'seating_capacity' => 7,
                'status' => 'available',
            ],
            [
                'brand' => 'Mitsubishi',
                'model' => 'Pajero Sport Dakar Ultimate',
                'license_plate' => 'B 9999 PJR',
                'daily_rate' => 1250000,
                'transmission' => 'Automatic',
                'seating_capacity' => 7,
                'status' => 'available',
            ],
            [
                'brand' => 'Hyundai',
                'model' => 'Ioniq 5 Long Range Signature',
                'license_plate' => 'B 1000 ELE',
                'daily_rate' => 1500000,
                'transmission' => 'Automatic',
                'seating_capacity' => 5,
                'status' => 'available',
            ],
            [
                'brand' => 'Daihatsu',
                'model' => 'Rocky 1.0 R Turbo CVT',
                'license_plate' => 'B 4123 RKY',
                'daily_rate' => 400000,
                'transmission' => 'Automatic',
                'seating_capacity' => 5,
                'status' => 'maintenance',
            ],
        ];

        foreach ($fleet as $carData) {
            Car::updateOrCreate(
                ['license_plate' => $carData['license_plate']],
                $carData
            );
        }
    }
}
