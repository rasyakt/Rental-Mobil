<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::where('status', 'available')
            ->with(['category', 'images']);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('brand', 'like', "%$search%")
                    ->orWhere('model', 'like', "%$search%");
            });
        }

        $vehicles = $query->paginate(12);

        return view('customer.vehicles.index', compact('vehicles'));
    }

    public function show($id)
    {
        $vehicle = Vehicle::with(['category', 'images', 'branch', 'features'])
            ->findOrFail($id);

        return view('customer.vehicles.show', compact('vehicle'));
    }
}
