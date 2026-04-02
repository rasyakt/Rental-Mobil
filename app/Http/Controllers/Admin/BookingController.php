<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['customer.user', 'vehicle', 'driver', 'pickupBranch', 'returnBranch'])
            ->latest()
            ->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['customer.user', 'vehicle', 'driver', 'pickupBranch', 'returnBranch', 'payments'])
            ->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::with(['customer.user', 'vehicle', 'driver', 'branch'])->findOrFail($id);
        $drivers = \App\Models\Driver::where('status', 'available')->get();
        return view('admin.bookings.edit', compact('booking', 'drivers'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());
        return redirect()->route('admin.bookings.show', $id)->with('success', 'Pesanan diperbarui.');
    }

    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'confirmed']);
        
        // Also update vehicle status
        $booking->vehicle->update(['status' => 'booked']);

        return redirect()->back()->with('success', 'Pesanan telah dikonfirmasi.');
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'cancelled']);
        
        // Ensure vehicle is free
        $booking->vehicle->update(['status' => 'available']);

        return redirect()->back()->with('success', 'Pesanan telah ditolak.');
    }

    public function assignDriver(Request $request, $id)
    {
        $request->validate(['driver_id' => 'required|exists:drivers,id']);
        
        $booking = Booking::findOrFail($id);

        // Release old driver if exists
        if ($booking->driver_id) {
            \App\Models\Driver::where('id', $booking->driver_id)->update(['status' => 'available']);
        }

        // Assign new driver and set to on_duty
        $booking->update(['driver_id' => $request->driver_id]);
        \App\Models\Driver::where('id', $request->driver_id)->update(['status' => 'on_duty']);

        return redirect()->back()->with('success', 'Sopir telah ditugaskan dan status diperbarui ke On-Duty.');
    }

    public function complete($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'completed']);
        
        // Release vehicle and driver
        $booking->vehicle->update(['status' => 'available']);
        if ($booking->driver_id) {
            $booking->driver->update(['status' => 'available']);
        }

        return redirect()->back()->with('success', 'Pesanan telah selesai.');
    }

    public function invoice($id)
    {
        $booking = Booking::with(['customer.user', 'vehicle', 'driver', 'branch', 'payment'])->findOrFail($id);
        return view('admin.bookings.invoice', compact('booking'));
    }

    public function reportDamage(Request $request, $id)
    {
        return response()->json(['success' => true]);
    }
}
