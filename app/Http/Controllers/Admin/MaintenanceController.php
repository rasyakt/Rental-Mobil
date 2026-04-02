<?php

namespace App\Http\Controllers\Admin;

use App\Models\Maintenance;
use App\Models\Vehicle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('vehicle')->latest()->paginate(10);
        return view('admin.maintenance.index', compact('maintenances'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status', '!=', 'sold')->get();
        return view('admin.maintenance.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.maintenance.index');
    }

    public function show($id)
    {
        $maintenance = Maintenance::with('vehicle')->findOrFail($id);
        return view('admin.maintenance.show', compact('maintenance'));
    }

    public function edit($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $vehicles = Vehicle::where('status', '!=', 'sold')->get();
        return view('admin.maintenance.edit', compact('maintenance', 'vehicles'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.maintenance.index');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.maintenance.index');
    }

    public function complete($id)
    {
        return response()->json(['success' => true]);
    }

    public function damagesIndex()
    {
        return view('admin.damages.index');
    }

    public function updateDamageStatus(Request $request, $id)
    {
        return response()->json(['success' => true]);
    }
}
