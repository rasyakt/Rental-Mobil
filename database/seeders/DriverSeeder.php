<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Driver;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branch = Branch::first();

        $drivers = [
            [
                'branch_id' => $branch->id,
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@rental-mobil.id',
                'phone' => '0812-3456-7890',
                'id_number' => '1234567890123456',
                'birth_date' => '1985-03-15',
                'gender' => 'male',
                'address' => 'Jl. Merdeka No. 123, Jakarta',
                'city' => 'Jakarta',
                'license_number' => '0112AA001234',
                'license_type' => 'B',
                'license_expiry_date' => '2026-05-10',
                'rating' => 4.8,
                'total_trips' => 450,
                'status' => 'available',
                'daily_rate' => 150000,
            ],
            [
                'branch_id' => $branch->id,
                'name' => 'Ahmad Wijaya',
                'email' => 'ahmad.wijaya@rental-mobil.id',
                'phone' => '0812-3456-7891',
                'id_number' => '1234567890123457',
                'birth_date' => '1988-07-22',
                'gender' => 'male',
                'address' => 'Jl. Sudirman No. 456, Jakarta',
                'city' => 'Jakarta',
                'license_number' => '0112AA001235',
                'license_type' => 'B',
                'license_expiry_date' => '2025-08-15',
                'rating' => 4.9,
                'total_trips' => 520,
                'status' => 'available',
                'daily_rate' => 150000,
            ],
            [
                'branch_id' => $branch->id,
                'name' => 'Suhartono',
                'email' => 'suhartono@rental-mobil.id',
                'phone' => '0812-3456-7892',
                'id_number' => '1234567890123458',
                'birth_date' => '1980-11-05',
                'gender' => 'male',
                'address' => 'Jl. Gatot Subroto No. 789, Jakarta',
                'city' => 'Jakarta',
                'license_number' => '0112AA001236',
                'license_type' => 'B',
                'license_expiry_date' => '2024-12-20',
                'rating' => 4.7,
                'total_trips' => 380,
                'status' => 'available',
                'daily_rate' => 150000,
            ],
            [
                'branch_id' => $branch->id,
                'name' => 'Rudi Hermawan',
                'email' => 'rudi.hermawan@rental-mobil.id',
                'phone' => '0812-3456-7893',
                'id_number' => '1234567890123459',
                'birth_date' => '1992-01-18',
                'gender' => 'male',
                'address' => 'Jl. Gatot Subroto No. 100, Jakarta',
                'city' => 'Jakarta',
                'license_number' => '0112AA001237',
                'license_type' => 'B',
                'license_expiry_date' => '2027-03-25',
                'rating' => 4.6,
                'total_trips' => 280,
                'status' => 'available',
                'daily_rate' => 150000,
            ],
        ];

        foreach ($drivers as $driver) {
            Driver::create($driver);
        }
    }
}
