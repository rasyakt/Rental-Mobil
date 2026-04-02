<?php

namespace Database\Seeders;

use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;

class VehicleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Ekonomi',
                'slug' => 'ekonomi',
                'description' => 'Mobil kecil hemat BBM untuk perjalanan singkat',
                'is_active' => true,
            ],
            [
                'name' => 'Standar',
                'slug' => 'standar',
                'description' => 'Mobil standar untuk kebutuhan sehari-hari',
                'is_active' => true,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'description' => 'Mobil premium dengan fasilitas lengkap',
                'is_active' => true,
            ],
            [
                'name' => 'SUV',
                'slug' => 'suv',
                'description' => 'SUV spacious untuk keluarga dan grup',
                'is_active' => true,
            ],
            [
                'name' => 'MPV',
                'slug' => 'mpv',
                'description' => 'MPV dengan kapasitas penumpang besar',
                'is_active' => true,
            ],
            [
                'name' => 'Mewah',
                'slug' => 'mewah',
                'description' => 'Mobil mewah untuk acara spesial',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            VehicleCategory::create($category);
        }
    }
}
