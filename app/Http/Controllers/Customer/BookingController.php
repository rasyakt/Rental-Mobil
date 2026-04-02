<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $customer = auth()->user()->customer;
        $bookings = Booking::where('customer_id', $customer->id)
            ->with(['vehicle', 'driver', 'pickupBranch', 'returnBranch'])
            ->latest()
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }

    public function create()
    {
        return view('customer.bookings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'pickup_date' => 'required|date|after:now',
            'return_date' => 'required|date|after:pickup_date',
            'pickup_branch_id' => 'required|exists:branches,id',
            'return_branch_id' => 'required|exists:branches,id',
            'with_driver' => 'required|boolean',
            'pickup_address' => 'required|string',
            'return_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $vehicle = \App\Models\Vehicle::findOrFail($validated['vehicle_id']);
        $pickupDate = \Carbon\Carbon::parse($validated['pickup_date']);
        $returnDate = \Carbon\Carbon::parse($validated['return_date']);
        $days = $pickupDate->diffInDays($returnDate) ?: 1;

        $totalPrice = $vehicle->price_per_day * $days;
        $additionalCharges = 0;
        
        if ($validated['with_driver']) {
            // Assume default driver rate if no driver selected yet
            $additionalCharges = 150000 * $days; 
        }

        $tax = $totalPrice * 0.11; // 11% PPN
        $finalPrice = $totalPrice + $additionalCharges + $tax;

        $booking = Booking::create([
            'booking_number' => 'BR-' . strtoupper(uniqid()),
            'customer_id' => auth()->user()->customer->id,
            'vehicle_id' => $vehicle->id,
            'pickup_branch_id' => $validated['pickup_branch_id'],
            'return_branch_id' => $validated['return_branch_id'],
            'pickup_date' => $pickupDate,
            'return_date' => $returnDate,
            'with_driver' => $validated['with_driver'],
            'pickup_address' => $validated['pickup_address'],
            'return_address' => $validated['return_address'],
            'total_price' => $totalPrice,
            'additional_charges' => $additionalCharges,
            'tax' => $tax,
            'final_price' => $finalPrice,
            'status' => 'pending',
            'notes' => $validated['notes'],
        ]);

        // Update vehicle status
        $vehicle->update(['status' => 'booked']);

        return redirect()->route('customer.bookings.show', $booking->id)
            ->with('success', 'Pesanan Anda berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public function show($id)
    {
        $booking = Booking::with(['vehicle.images', 'driver', 'pickupBranch', 'returnBranch', 'payments'])
            ->where('customer_id', auth()->user()->customer->id)
            ->findOrFail($id);
        return view('customer.bookings.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('customer.bookings.edit', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        // Implementation
        return redirect()->route('customer.bookings.show', $id);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return redirect()->route('customer.bookings.index');
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        if (in_array($booking->status, ['pending', 'confirmed'])) {
            $booking->status = 'cancelled';
            $booking->save();
        }
        return redirect()->route('customer.bookings.show', $id);
    }
}
