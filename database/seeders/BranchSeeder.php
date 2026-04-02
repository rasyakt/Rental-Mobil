<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Kantor Pusat Jakarta',
                'slug' => 'jakarta-pusat',
                'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'postal_code' => '12910',
                'phone' => '(021) 123-4567',
                'email' => 'jakarta@rental-mobil.id',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'opening_hour' => '08:00',
                'closing_hour' => '20:00',
                'is_active' => true,
            ],
            [
                'name' => 'Cabang Surabaya',
                'slug' => 'surabaya',
                'address' => 'Jl. Ahmad Yani No. 456, Surabaya',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
                'postal_code' => '60123',
                'phone' => '(031) 234-5678',
                'email' => 'surabaya@rental-mobil.id',
                'latitude' => -7.2575,
                'longitude' => 112.7521,
                'opening_hour' => '08:00',
                'closing_hour' => '20:00',
                'is_active' => true,
            ],
            [
                'name' => 'Cabang Bandung',
                'slug' => 'bandung',
                'address' => 'Jl. Jalan Braga No. 789, Bandung',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'postal_code' => '40123',
                'phone' => '(022) 345-6789',
                'email' => 'bandung@rental-mobil.id',
                'latitude' => -6.9147,
                'longitude' => 107.6098,
                'opening_hour' => '08:00',
                'closing_hour' => '20:00',
                'is_active' => true,
            ],
            [
                'name' => 'Cabang Medan',
                'slug' => 'medan',
                'address' => 'Jl. Gatot Subroto No. 321, Medan',
                'city' => 'Medan',
                'province' => 'Sumatera Utara',
                'postal_code' => '20123',
                'phone' => '(061) 456-7890',
                'email' => 'medan@rental-mobil.id',
                'latitude' => 3.1957,
                'longitude' => 101.6947,
                'opening_hour' => '08:00',
                'closing_hour' => '20:00',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
