
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h2 class="mb-3">Browse Listings</h2>

    <form action="{{ route('listings.index') }}" method="GET"
          class="card card-body shadow-sm mb-4">

        <div class="row g-2">

            <div class="col-md-4">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Search products or services"
                       value="{{ request('search') }}">
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
                <input type="number"
                       name="min_price"
                       class="form-control"
                       placeholder="Min"
                       min="0"
                       value="{{ request('min_price') }}">
            </div>

            <div class="col-md-1">
                <input type="number"
                       name="max_price"
                       class="form-control"
                       placeholder="Max"
                       min="0"
                       value="{{ request('max_price') }}">
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Search
                </button>

                <a href="{{ route('listings.index') }}"
                   class="btn btn-outline-secondary">
                    Clear
                </a>
            </div>

        </div>

    </form>

    <p class="text-muted">
        {{ $listings->total() }} listings found
    </p>

    @if($listings->count() > 0)

        <div class="row">

            @foreach($listings as $listing)

                <div class="col-md-4 mb-4">

                    <div class="card h-100 shadow-sm">

                        <div class="card-body">

                            <span class="badge bg-secondary">
                                {{ ucfirst($listing->listing_type) }}
                            </span>

                            <h5 class="mt-2">
                                {{ $listing->name }}
                            </h5>

                            <h5 class="text-primary">
                                @if($listing->price !== null)
                                    ₹{{ number_format($listing->price, 2) }}
                                @else
                                    Price on Request
                                @endif
                            </h5>

                            <p class="text-muted mb-1">
                                {{ $listing->category->name ?? 'N/A' }}
                            </p>

                            <p class="text-muted">
                                {{ $listing->area->name ?? '' }}
                                {{ $listing->city->name ?? '' }}
                            </p>

                            <a href="{{ route('listings.show', $listing->slug) }}"
                               class="btn btn-primary btn-sm">
                                View Details
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        {{ $listings->links('pagination::bootstrap-5') }}

    @else

        <div class="alert alert-info">
            No listings found. Try changing your search or filters.
        </div>

    @endif

</div>

@endsection
