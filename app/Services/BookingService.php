<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Vehicle;
use Carbon\Carbon;

class BookingService
{
    /**
     * Calculate rental price based on vehicle and dates
     */
    public function calculatePrice(Vehicle $vehicle, $pickupDate, $returnDate, $rentalType, $withDriver = false)
    {
        $pickupDate = Carbon::parse($pickupDate);
        $returnDate = Carbon::parse($returnDate);
        $daysCount = $pickupDate->diffInDays($returnDate);

        $totalPrice = 0;

        // Calculate vehicle price
        if ($rentalType === 'weekly') {
            $totalPrice = $vehicle->price_weekly;
        } elseif ($rentalType === 'monthly') {
            $totalPrice = $vehicle->price_monthly;
        } else {
            $totalPrice = $vehicle->price_daily * $daysCount;
        }

        // Add driver price if needed
        if ($withDriver && $vehicle->price_driver_daily > 0) {
            $totalPrice += ($vehicle->price_driver_daily * $daysCount);
        }

        return $totalPrice;
    }

    /**
     * Check vehicle availability for dates
     */
    public function isVehicleAvailable(Vehicle $vehicle, $pickupDate, $returnDate)
    {
        return $vehicle->isAvailable($pickupDate, $returnDate);
    }

    /**
     * Create a new booking with all calculations
     */
    public function createBooking($customerId, $vehicleId, $driverId, $pickupBranchId, $returnBranchId, $pickupDate, $returnDate, $rentalType, $withDriver, $pickupAddress, $returnAddress, $notes = null)
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
        
        // Validate availability
        if (!$this->isVehicleAvailable($vehicle, $pickupDate, $returnDate)) {
            throw new \Exception('Kendaraan tidak tersedia untuk tanggal yang dipilih');
        }

        // Calculate price
        $totalPrice = $this->calculatePrice($vehicle, $pickupDate, $returnDate, $rentalType, $withDriver);
        $tax = $totalPrice * 0.1; // 10% tax
        $finalPrice = $totalPrice + $tax;

        // Create booking
        $booking = Booking::create([
            'booking_number' => 'BK' . date('YmdHis') . random_int(100, 999),
            'customer_id' => $customerId,
            'vehicle_id' => $vehicleId,
            'driver_id' => $driverId ?? null,
            'pickup_branch_id' => $pickupBranchId,
            'return_branch_id' => $returnBranchId,
            'pickup_date' => $pickupDate,
            'return_date' => $returnDate,
            'rental_type' => $rentalType,
            'with_driver' => $withDriver,
            'pickup_address' => $pickupAddress,
            'return_address' => $returnAddress,
            'total_price' => $totalPrice,
            'tax' => $tax,
            'discount' => 0,
            'additional_charges' => 0,
            'final_price' => $finalPrice,
            'status' => 'pending',
            'notes' => $notes,
        ]);

        return $booking;
    }

    /**
     * Cancel a booking
     */
    public function cancelBooking(Booking $booking, $reason = null)
    {
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            throw new \Exception('Hanya booking dengan status pending atau confirmed yang dapat dibatalkan');
        }

        $booking->update([
            'status' => 'cancelled',
            'admin_notes' => $reason,
        ]);

        // Make vehicle available again if it was reserved
        if ($booking->vehicle) {
            $booking->vehicle->update(['status' => 'available']);
        }

        return $booking;
    }

    /**
     * Confirm a booking
     */
    public function confirmBooking(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            throw new \Exception('Hanya booking dengan status pending yang dapat dikonfirmasi');
        }

        // Check vehicle availability again
        if (!$this->isVehicleAvailable($booking->vehicle, $booking->pickup_date, $booking->return_date)) {
            throw new \Exception('Kendaraan tidak lagi tersedia untuk tanggal yang dipilih');
        }

        $booking->update(['status' => 'confirmed']);
        return $booking;
    }
}
