<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();

        foreach ($customers->take(3) as $customer) {
            $vehicle = $vehicles->random();
            $driver = $drivers->random();
            
            $pickupDate = now()->addDays(rand(5, 15));
            $returnDate = $pickupDate->clone()->addDays(rand(2, 7));
            
            $rentalType = ['daily', 'weekly', 'monthly'][rand(0, 2)];
            $withDriver = rand(0, 1) ? true : false;

            $pricePerDay = $vehicle->price_daily;
            $daysCount = $pickupDate->diffInDays($returnDate);
            
            if ($rentalType === 'weekly') {
                $totalPrice = $vehicle->price_weekly;
            } elseif ($rentalType === 'monthly') {
                $totalPrice = $vehicle->price_monthly;
            } else {
                $totalPrice = $pricePerDay * $daysCount;
            }

            if ($withDriver) {
                $totalPrice += ($driver->daily_rate * $daysCount);
            }

            $tax = $totalPrice * 0.1;
            $finalPrice = $totalPrice + $tax;

            Booking::create([
                'booking_number' => 'BK' . rand(100000, 999999),
                'customer_id' => $customer->id,
                'vehicle_id' => $vehicle->id,
                'driver_id' => $withDriver ? $driver->id : null,
                'pickup_branch_id' => 1,
                'return_branch_id' => 1,
                'pickup_date' => $pickupDate,
                'return_date' => $returnDate,
                'rental_type' => $rentalType,
                'with_driver' => $withDriver,
                'pickup_address' => 'Kantor Pusat Jakarta',
                'return_address' => 'Kantor Pusat Jakarta',
                'total_price' => $totalPrice,
                'tax' => $tax,
                'discount' => 0,
                'additional_charges' => 0,
                'final_price' => $finalPrice,
                'status' => ['pending', 'confirmed', 'active'][rand(0, 2)],
                'notes' => 'Booking sample data',
            ]);
        }
    }
}
