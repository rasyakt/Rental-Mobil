<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vehicle;
use App\Models\Branch;
use App\Models\VehicleCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with(['branch', 'category', 'images'])->paginate(10);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        $categories = VehicleCategory::where('is_active', true)->get();
        return view('admin.vehicles.create', compact('branches', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'plate_number' => 'required|string|unique:vehicles,plate_number',
            'category_id' => 'required|exists:vehicle_categories,id',
            'branch_id' => 'required|exists:branches,id',
            'price_per_day' => 'required|numeric|min:0',
            'transmission' => 'required|in:manual,automatic',
            'fuel_type' => 'required|string',
            'seats' => 'required|integer|min:1',
            'color' => 'required|string',
            'status' => 'required|in:available,booked,maintenance,not_available,sold',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $vehicle = Vehicle::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicles', 'public');
                $vehicle->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $vehicle = Vehicle::with(['branch', 'category', 'images', 'features'])->findOrFail($id);
        return view('admin.vehicles.show', compact('vehicle'));
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $branches = Branch::where('is_active', true)->get();
        $categories = VehicleCategory::where('is_active', true)->get();
        return view('admin.vehicles.edit', compact('vehicle', 'branches', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'plate_number' => 'required|string|unique:vehicles,plate_number,' . $id,
            'category_id' => 'required|exists:vehicle_categories,id',
            'branch_id' => 'required|exists:branches,id',
            'price_per_day' => 'required|numeric|min:0',
            'transmission' => 'required|in:manual,automatic',
            'fuel_type' => 'required|string',
            'seats' => 'required|integer|min:1',
            'color' => 'required|string',
            'status' => 'required|in:available,booked,maintenance,not_available,sold',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $vehicle->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicles', 'public');
                $vehicle->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.vehicles.index')->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.vehicles.index');
    }

    public function uploadImages(Request $request, $id)
    {
        return response()->json(['success' => true]);
    }

    public function deleteImage($id, $imageId)
    {
        return response()->json(['success' => true]);
    }

    public function changeStatus(Request $request, $id)
    {
        return response()->json(['success' => true]);
    }

    public function trackingHistory($id)
    {
        $vehicle = \App\Models\Vehicle::findOrFail($id);
        $maintenance = \App\Models\Maintenance::where('vehicle_id', $vehicle->id)->latest()->get();
        $bookings = \App\Models\Booking::where('vehicle_id', $vehicle->id)->latest()->get();
        return view('admin.vehicles.tracking', compact('vehicle', 'maintenance', 'bookings'));
    }
}
