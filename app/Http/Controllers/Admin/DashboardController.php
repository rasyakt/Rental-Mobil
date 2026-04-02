<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\Driver;
use App\Models\Payment;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'active_bookings' => Booking::where('status', 'active')->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            
            'total_vehicles' => Vehicle::count(),
            'available_vehicles' => Vehicle::where('status', 'available')->count(),
            'rented_vehicles' => Vehicle::where('status', 'rented')->count(),
            'maintenance_vehicles' => Vehicle::where('status', 'maintenance')->count(),
            
            'total_revenue' => Booking::where('status', 'completed')->sum('final_price'),
            'pending_revenue' => Booking::where('status', 'confirmed')->sum('final_price'),
            'today_revenue' => Booking::whereDate('created_at', today())
                ->where('status', 'completed')
                ->sum('final_price'),
            
            'total_drivers' => Driver::count(),
            'available_drivers' => Driver::where('status', 'available')->count(),
            'on_duty_drivers' => Driver::where('status', 'on_duty')->count(),
            
            'total_branches' => Branch::count(),
            'active_branches' => Branch::where('is_active', true)->count(),
            
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
        ];

        // Get revenue data for chart
        $bookings = Booking::where('status', 'completed')
            ->whereYear('created_at', date('Y'))
            ->get()
            ->groupBy(function ($item) {
                return $item->created_at->format('m');
            })
            ->map(function ($group) {
                return $group->sum('final_price');
            });

        $revenueChartLabels = [];
        $revenueChartData = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = \Carbon\Carbon::createFromDate(null, $i, 1)->locale('id')->monthName;
            $revenueChartLabels[] = $month;
            $revenueChartData[] = $bookings->get(str_pad($i, 2, '0', STR_PAD_LEFT), 0);
        }

        // Recent bookings
        $recentBookings = Booking::with(['customer.user', 'vehicle'])
            ->latest()
            ->take(5)
            ->get();

        // Top vehicles
        $topVehicles = Booking::select('vehicle_id')
            ->whereIn('status', ['completed', 'active', 'confirmed'])
            ->groupBy('vehicle_id')
            ->selectRaw('vehicle_id, count(*) as total')
            ->with('vehicle')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'revenueChartLabels',
            'revenueChartData',
            'recentBookings',
            'topVehicles'
        ));
    }

    public function statistics()
    {
        // Return JSON for AJAX requests
        $stats = [
            'total_bookings' => Booking::count(),
            'total_revenue' => Booking::where('status', 'completed')->sum('final_price'),
            'avg_booking_value' => Booking::where('status', 'completed')->avg('final_price'),
        ];

        return response()->json($stats);
    }
}
