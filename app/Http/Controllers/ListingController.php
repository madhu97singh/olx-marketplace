<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Category;
use App\Models\Country;
use App\Http\Requests\StoreListingRequest;
use Illuminate\Support\Str;
use App\Http\Requests\UpdateListingRequest;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    // Homepage and all listings
    
    public function index()
    {
        $query = Listing::with(['user', 'category', 'city', 'area'])
            ->where('status', 'active');

        // Search by listing name or description
        if (request()->filled('search')) {
            $search = request('search');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('detail', 'like', "%{$search}%");
            });
        }

        // Filter by category slug
        if (request()->filled('category')) {
            $query->whereHas('category', function ($q) {
                $q->where('slug', request('category'));
            });
        }

        // Filter by city slug
        if (request()->filled('city')) {
            $query->whereHas('city', function ($q) {
                $q->where('slug', request('city'));
            });
        }

        // Filter by minimum price
        if (request()->filled('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }

        // Filter by maximum price
        if (request()->filled('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        $listings = $query->latest()->paginate(12)->withQueryString();

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        $cities = \App\Models\City::orderBy('name')->get();

        if (request()->routeIs('listings.index')) {
            return view('listings.index', compact(
                'listings',
                'categories',
                'cities'
            ));
        }

        return view('home', compact(
            'listings',
            'categories',
            'cities'
        ));
    }

    // Show add listing form
    public function create()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        $countries = Country::orderBy('name')->get();

        return view('listings.create', compact(
            'categories',
            'countries'
        ));
    }

    // Store listing
    public function store(StoreListingRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        $data['slug'] = Str::slug($data['name'])
            . '-' . Str::lower(Str::random(6));

        $data['status'] = 'active';

        Listing::create($data);

        return redirect('/')
            ->with('success', 'Your listing has been published successfully!');
    }

    // Show individual listing
    public function show(Listing $listing)
    {
        abort_unless($listing->status === 'active', 404);

        $listing->load([
            'user',
            'category',
            'subcategory',
            'country',
            'state',
            'city',
            'area'
        ]);

        $relatedListings = Listing::with([
            'city',
            'category'
        ])
        ->where('category_id', $listing->category_id)
        ->where('status', 'active')
        ->where('id', '!=', $listing->id)
        ->latest()
        ->take(4)
        ->get();

        return view('listings.show', compact(
            'listing',
            'relatedListings'
        ));
    }

    // Show user's own listings
    public function myListings()
    {
        $listings = Listing::with([
            'category',
            'city'
        ])
        ->where('user_id', auth()->id())
        ->latest()
        ->paginate(10);

        return view('listings.my-listings', compact('listings'));
    }

    public function edit(Listing $listing)
    {
        abort_unless($listing->user_id === auth()->id(), 403);

        $listing->load(['category', 'subcategory', 'country', 'state', 'city', 'area']);

        $categories = Category::where('is_active', true)
            ->orderBy('name')->get();

        $countries = Country::orderBy('name')->get();

        return view('listings.edit', compact(
            'listing',
            'categories',
            'countries'
        ));
    }

    public function update(UpdateListingRequest $request, Listing $listing)
    {
        abort_unless($listing->user_id === auth()->id(), 403);

        $data = $request->validated();

        if ($listing->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']).'-'.Str::lower(Str::random(6));
        }

        $listing->update($data);

        return redirect()->route('listings.mine')
            ->with('success', 'Listing updated successfully!');
    }

    public function destroy(Listing $listing)
    {
        abort_unless($listing->user_id === auth()->id(), 403);

        $listing->delete();

        return redirect()->route('listings.mine')
            ->with('success', 'Listing deleted successfully!');
    }

    public function updateStatus(Request $request, Listing $listing)
    {
        abort_unless($listing->user_id === auth()->id(), 403);

        $request->validate([
            'status' => 'required|in:active,inactive,sold',
        ]);

        $listing->update([
            'status' => $request->status,
        ]);

        return redirect()->route('listings.mine')
            ->with('success', 'Listing status updated successfully!');
    }
}