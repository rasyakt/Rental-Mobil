<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            BranchSeeder::class,
            VehicleCategorySeeder::class,
            VehicleSeeder::class,
            DriverSeeder::class,
            UserSeeder::class,
            BookingSeeder::class,
        ]);
    }
}

