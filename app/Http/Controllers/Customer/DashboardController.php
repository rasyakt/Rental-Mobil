<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $customer = auth()->user()->customer;
        
        $bookings = Booking::where('customer_id', $customer->id)
            ->with(['vehicle', 'driver', 'pickupBranch', 'returnBranch'])
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'active_bookings' => Booking::where('customer_id', $customer->id)
                ->whereIn('status', ['confirmed', 'active'])
                ->count(),
            'completed_bookings' => Booking::where('customer_id', $customer->id)
                ->where('status', 'completed')
                ->count(),
            'total_spent' => Booking::where('customer_id', $customer->id)
                ->where('status', 'completed')
                ->sum('final_price'),
        ];

        return view('customer.dashboard', compact('customer', 'bookings', 'stats'));
    }
}
