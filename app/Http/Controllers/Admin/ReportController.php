<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Payment;
use App\Models\Driver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue' => Payment::where('status', 'success')->sum('amount'),
            'total_bookings' => Booking::count(),
            'total_vehicles' => Vehicle::count(),
            'total_drivers' => Driver::count(),
            'recent_revenue' => Payment::where('status', 'success')->orderBy('created_at', 'desc')->take(5)->get(),
        ];

        return view('admin.reports.index', compact('stats'));
    }

    public function revenue()
    {
        return view('admin.reports.revenue');
    }

    public function bookings()
    {
        return view('admin.reports.bookings');
    }

    public function vehicles()
    {
        return view('admin.reports.vehicles');
    }

    public function drivers()
    {
        return view('admin.reports.drivers');
    }

    public function export(Request $request)
    {
        return response()->json(['success' => true]);
    }
}
