<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use App\Models\VehicleImage;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branch = Branch::first();
        
        $vehicles = [
            [
                'branch_id' => $branch->id,
                'category_id' => VehicleCategory::where('slug', 'ekonomi')->first()->id,
                'plat_number' => 'B 1234 ABC',
                'brand' => 'Toyota',
                'model' => 'Avanza',
                'year' => 2023,
                'color' => 'Merah',
                'seat_capacity' => 7,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'price_daily' => 350000,
                'price_weekly' => 2300000,
                'price_monthly' => 8500000,
                'price_driver_daily' => 150000,
                'status' => 'available',
                'total_km' => 15000,
                'service_interval_km' => 10000,
            ],
            [
                'branch_id' => $branch->id,
                'category_id' => VehicleCategory::where('slug', 'standar')->first()->id,
                'plat_number' => 'B 2345 DEF',
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => 2023,
                'color' => 'Silver',
                'seat_capacity' => 5,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'price_daily' => 450000,
                'price_weekly' => 2900000,
                'price_monthly' => 10500000,
                'price_driver_daily' => 150000,
                'status' => 'available',
                'total_km' => 12000,
                'service_interval_km' => 10000,
            ],
            [
                'branch_id' => $branch->id,
                'category_id' => VehicleCategory::where('slug', 'premium')->first()->id,
                'plat_number' => 'B 3456 GHI',
                'brand' => 'Honda',
                'model' => 'Accord',
                'year' => 2023,
                'color' => 'Hitam',
                'seat_capacity' => 5,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'price_daily' => 650000,
                'price_weekly' => 4200000,
                'price_monthly' => 15000000,
                'price_driver_daily' => 200000,
                'status' => 'available',
                'total_km' => 8000,
                'service_interval_km' => 10000,
            ],
            [
                'branch_id' => $branch->id,
                'category_id' => VehicleCategory::where('slug', 'suv')->first()->id,
                'plat_number' => 'B 4567 JKL',
                'brand' => 'Toyota',
                'model' => 'Fortuner',
                'year' => 2022,
                'color' => 'Putih',
                'seat_capacity' => 7,
                'transmission' => 'automatic',
                'fuel_type' => 'diesel',
                'price_daily' => 750000,
                'price_weekly' => 4900000,
                'price_monthly' => 17500000,
                'price_driver_daily' => 200000,
                'status' => 'available',
                'total_km' => 25000,
                'service_interval_km' => 10000,
            ],
            [
                'branch_id' => $branch->id,
                'category_id' => VehicleCategory::where('slug', 'mpv')->first()->id,
                'plat_number' => 'B 5678 MNO',
                'brand' => 'Nissan',
                'model' => 'Serena',
                'year' => 2023,
                'color' => 'Abu-abu',
                'seat_capacity' => 8,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'price_daily' => 550000,
                'price_weekly' => 3600000,
                'price_monthly' => 12500000,
                'price_driver_daily' => 150000,
                'status' => 'available',
                'total_km' => 10000,
                'service_interval_km' => 10000,
            ],
            [
                'branch_id' => $branch->id,
                'category_id' => VehicleCategory::where('slug', 'mewah')->first()->id,
                'plat_number' => 'B 6789 PQR',
                'brand' => 'BMW',
                'model' => '320i',
                'year' => 2023,
                'color' => 'Biru Tua',
                'seat_capacity' => 5,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'price_daily' => 1200000,
                'price_weekly' => 7800000,
                'price_monthly' => 28000000,
                'price_driver_daily' => 250000,
                'status' => 'available',
                'total_km' => 5000,
                'service_interval_km' => 10000,
            ],
        ];

        foreach ($vehicles as $vehicleData) {
            $vehicle = Vehicle::create($vehicleData);
            
            // Add sample images
            VehicleImage::create([
                'vehicle_id' => $vehicle->id,
                'path' => 'vehicles/default-car-1.jpg',
                'is_primary' => true,
                'order' => 1,
            ]);
            
            VehicleImage::create([
                'vehicle_id' => $vehicle->id,
                'path' => 'vehicles/default-car-2.jpg',
                'is_primary' => false,
                'order' => 2,
            ]);
        }
    }
}
