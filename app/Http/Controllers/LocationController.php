<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\State;
use App\Models\City;
use App\Models\Area;

class LocationController extends Controller
{
    // Get subcategories
    public function subcategories(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id'
        ]);

        return response()->json(
            Subcategory::where('category_id', $request->category_id)
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name'])
        );
    }

    // Get states
    public function states(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id'
        ]);

        return response()->json(
            State::where('country_id', $request->country_id)
                ->orderBy('name')
                ->get(['id', 'name'])
        );
    }

    // Get cities
    public function cities(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id'
        ]);

        return response()->json(
            City::where('state_id', $request->state_id)
                ->orderBy('name')
                ->get(['id', 'name'])
        );
    }

    // Get areas
    public function areas(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id'
        ]);

        return response()->json(
            Area::where('city_id', $request->city_id)
                ->orderBy('name')
                ->get(['id', 'name'])
        );
    }
}