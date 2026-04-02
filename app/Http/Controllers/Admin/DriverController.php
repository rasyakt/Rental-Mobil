<?php

namespace App\Http\Controllers\Admin;

use App\Models\Driver;
use App\Models\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::with(['branch'])->paginate(10);
        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('admin.drivers.create', compact('branches'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.drivers.index');
    }

    public function show($id)
    {
        $driver = Driver::with(['branch', 'schedules'])->findOrFail($id);
        return view('admin.drivers.show', compact('driver'));
    }

    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        $branches = Branch::where('is_active', true)->get();
        return view('admin.drivers.edit', compact('driver', 'branches'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.drivers.index');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.drivers.index');
    }

    public function uploadPhoto(Request $request, $id)
    {
        return response()->json(['success' => true]);
    }

    public function changeStatus(Request $request, $id)
    {
        return response()->json(['success' => true]);
    }

    public function schedule($id)
    {
        $driver = \App\Models\Driver::findOrFail($id);
        $bookings = \App\Models\Booking::where('driver_id', $driver->id)->latest()->get();
        return view('admin.drivers.schedule', compact('driver', 'bookings'));
    }

    public function updateSchedule(Request $request, $id)
    {
        return response()->json(['success' => true]);
    }
}
