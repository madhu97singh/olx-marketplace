@extends('layouts.app')

@section('title', 'OLX Marketplace - Buy and Sell')

@section('content')

<div class="py-4">

    <!-- Search Section -->
    <div class="bg-white p-4 rounded shadow-sm mb-4">

        <h2 class="text-center mb-3">
            Find Products and Services Near You
        </h2>

        
        <form action="{{ route('listings.index') }}" method="GET" class="card card-body shadow-sm mb-4">

            <h5 class="mb-3">Find Products and Services</h5>

            <div class="row g-2">

                <div class="col-md-4">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search products or services..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-md-2">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}"
                                {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-2">
                    <select name="city" class="form-select">
                        <option value="">All Cities</option>

                        @foreach($cities as $city)
                            <option value="{{ $city->slug }}"
                                {{ request('city') == $city->slug ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-1">
                    <input
                        type="number"
                        name="min_price"
                        class="form-control"
                        placeholder="Min ₹"
                        min="0"
                        value="{{ request('min_price') }}"
                    >
                </div>

                <div class="col-md-1">
                    <input
                        type="number"
                        name="max_price"
                        class="form-control"
                        placeholder="Max ₹"
                        min="0"
                        value="{{ request('max_price') }}"
                    >
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Search
                    </button>

                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        Clear
                    </a>
                </div>

            </div>

        </form>


    </div>


    <!-- Categories -->
    <h4 class="mb-3">Browse Categories</h4>

    <div class="row mb-5">

        @foreach($categories as $category)

            <div class="col-6 col-md-2 mb-3">

                <a href="{{ route('listings.index', ['category' => $category->slug]) }}"
                   class="text-decoration-none text-dark">

                    <div class="card text-center p-3 h-100">

                        <h6 class="mb-0">
                            {{ $category->name }}
                        </h6>

                    </div>

                </a>

            </div>

        @endforeach

    </div>


    <!-- Latest Listings -->
    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4>Latest Listings</h4>

        <a href="{{ route('listings.index') }}"
           class="text-decoration-none">
            View All
        </a>

    </div>


    <div class="row">

        @forelse($listings as $listing)

            <div class="col-md-3 col-sm-6 mb-4">

                <div class="card h-100 shadow-sm">

                    <div class="card-body">

                        <span class="badge bg-secondary mb-2">
                            {{ ucfirst($listing->listing_type) }}
                        </span>

                        <h5 class="card-title">
                            {{ $listing->name }}
                        </h5>

                        <h5 class="text-success">
                            @if($listing->price !== null)
                                ₹{{ number_format((float) $listing->price, 2) }}
                            @else
                                Price on Request
                            @endif
                        </h5>

                        <p class="text-muted mb-1">
                            {{ $listing->category->name }}
                        </p>

                        <p class="text-muted small">
                            {{ $listing->area?->name ? $listing->area->name . ', ' : '' }}{{ $listing->city->name }}
                        </p>

                        <p class="small text-muted">
                            {{ $listing->created_at->diffForHumans() }}
                        </p>

                        <a href="{{ route('listings.show', $listing->slug) }}"
                           class="btn btn-marketplace w-100">

                            View Details

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-info">
                    No listings available yet. Be the first to post an advertisement!
                </div>

            </div>

        @endforelse

    </div>

    <div class="mt-3">
        {{ $listings->links() }}
    </div>

</div>

@endsection