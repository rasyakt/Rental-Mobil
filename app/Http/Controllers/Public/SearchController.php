<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('public.search');
    }

    public function vehicles(Request $request)
    {
        $query = Vehicle::where('status', 'available')->with(['category', 'images']);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by price range
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $minPrice = $request->input('min_price', 0);
            $maxPrice = $request->input('max_price', 999999999);
            $query->whereBetween('price_daily', [$minPrice, $maxPrice]);
        }

        // Filter by transmission
        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        // Filter by capacity
        if ($request->filled('capacity')) {
            $query->where('seat_capacity', '>=', $request->capacity);
        }

        // Search by brand/model
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('brand', 'like', "%$search%")
                    ->orWhere('model', 'like', "%$search%");
            });
        }

        $vehicles = $query->paginate(12);

        return view('public.search-results', compact('vehicles'));
    }
}
