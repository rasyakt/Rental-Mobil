<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $adminUser = User::create([
            'name' => 'Admin Rental Mobil',
            'email' => 'admin@rental-mobil.id',
            'phone' => '0812-1111-1111',
            'password' => Hash::make('password123'),
            'user_type' => 'admin',
            'is_active' => true,
        ]);
        $adminUser->roles()->attach(Role::where('name', 'admin')->first());

        // Create Staff Users
        $staffUser1 = User::create([
            'name' => 'Eka Putri',
            'email' => 'eka.putri@rental-mobil.id',
            'phone' => '0812-2222-2222',
            'password' => Hash::make('password123'),
            'user_type' => 'staff',
            'branch_id' => 1,
            'is_active' => true,
        ]);
        $staffUser1->roles()->attach(Role::where('name', 'staff')->first());

        $staffUser2 = User::create([
            'name' => 'Rina Wijaya',
            'email' => 'rina.wijaya@rental-mobil.id',
            'phone' => '0812-2222-2223',
            'password' => Hash::make('password123'),
            'user_type' => 'staff',
            'branch_id' => 1,
            'is_active' => true,
        ]);
        $staffUser2->roles()->attach(Role::where('name', 'staff')->first());

        // Create Customer Users
        $customerUsers = [
            [
                'name' => 'Agus Hermanto',
                'email' => 'agus.hermanto@example.com',
                'phone' => '0812-3333-3333',
                'password' => Hash::make('password123'),
                'user_type' => 'customer',
                'is_active' => true,
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nur@example.com',
                'phone' => '0812-3333-3334',
                'password' => Hash::make('password123'),
                'user_type' => 'customer',
                'is_active' => true,
            ],
            [
                'name' => 'Bambang Surachman',
                'email' => 'bambang.s@example.com',
                'phone' => '0812-3333-3335',
                'password' => Hash::make('password123'),
                'user_type' => 'customer',
                'is_active' => true,
            ],
            [
                'name' => 'Dwi Cahaya',
                'email' => 'dwi.cahaya@example.com',
                'phone' => '0812-3333-3336',
                'password' => Hash::make('password123'),
                'user_type' => 'customer',
                'is_active' => true,
            ],
        ];

        foreach ($customerUsers as $customerData) {
            $customerUser = User::create($customerData);
            $customerUser->roles()->attach(Role::where('name', 'customer')->first());

            // Create customer profile
            Customer::create([
                'user_id' => $customerUser->id,
                'phone' => $customerData['phone'],
                'id_number' => rand(1000000000000000, 9999999999999999),
                'id_type' => 'ktp',
                'birth_date' => now()->subYears(rand(25, 65)),
                'gender' => rand(0, 1) ? 'male' : 'female',
                'address' => 'Jl. Example No. ' . rand(1, 999),
                'city' => 'Jakarta',
                'postal_code' => '12910',
                'is_verified' => true,
                'verified_at' => now(),
                'total_bookings' => 0,
                'rating' => 0,
            ]);
        }
    }
}
