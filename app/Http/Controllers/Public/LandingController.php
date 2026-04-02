<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::where('status', 'available')
            ->with(['category', 'images'])
            ->take(6)
            ->get();

        $branches = Branch::where('is_active', true)->get();

        $stats = [
            'total_vehicles' => Vehicle::count(),
            'total_bookings' => \App\Models\Booking::count(),
            'total_drivers' => \App\Models\Driver::count(),
            'total_branches' => $branches->count(),
        ];

        return view('public.landing', compact('vehicles', 'branches', 'stats'));
    }

    public function vehicles()
    {
        $categories = VehicleCategory::where('is_active', true)->get();
        $vehicles = Vehicle::where('status', 'available')
            ->with(['category', 'images'])
            ->paginate(12);

        return view('public.vehicles', compact('vehicles', 'categories'));
    }

    public function vehicleDetail($id)
    {
        $vehicle = Vehicle::with(['category', 'images', 'branch', 'features'])->findOrFail($id);
        $similarVehicles = Vehicle::where('category_id', $vehicle->category_id)
            ->where('id', '!=', $id)
            ->where('status', 'available')
            ->take(3)
            ->get();

        return view('public.vehicle-detail', compact('vehicle', 'similarVehicles'));
    }

    public function about()
    {
        return view('public.about');
    }

    public function branches()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('public.branches', compact('branches'));
    }

    public function faq()
    {
        return view('public.faq');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Send email or save to database
        // For now, just show success message
        return redirect()->back()->with('success', 'Pesan Anda telah dikirim. Terima kasih!');
    }
}
