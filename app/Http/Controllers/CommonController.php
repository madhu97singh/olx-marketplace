<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Area;
use App\Models\Subcategory;

class CommonController extends Controller
{
    public function index()
    {
        $categories = Category::with('subcategories')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $countries = Country::orderBy('name')->get();

        $states = State::orderBy('name')->get();

        $cities = City::orderBy('name')->get();

        $areas = Area::orderBy('name')->get();

        return view('common.index', compact(
            'categories',
            'countries',
            'states',
            'cities',
            'areas'
        ));
    }
}