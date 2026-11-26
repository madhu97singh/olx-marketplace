@extends('layouts.app')

@section('title', $listing->name)

@section('content')

<div class="py-4">

    <div class="row">

        <!-- Listing Information -->
        <div class="col-md-8">

            <div class="card shadow-sm mb-4">

                <div class="card-body p-4">

                    <span class="badge bg-secondary">
                        {{ ucfirst($listing->listing_type) }}
                    </span>

                    <h2 class="mt-3">
                        {{ $listing->name }}
                    </h2>

                    <h3 class="text-success mt-3">

                        @if($listing->price !== null)
                            ₹{{ number_format((float) $listing->price, 2) }}
                        @else
                            Price on Request
                        @endif

                    </h3>

                    <hr>

                    <h5>Description</h5>

                    <p style="white-space: pre-line;">
                        {{ $listing->detail }}
                    </p>

                    <hr>

                    <h5>Category Details</h5>

                    <p>
                        Category: {{ $listing->category->name }}
                    </p>

                    <p>
                        Subcategory: {{ $listing->subcategory?->name ?? 'Not specified' }}
                    </p>

                    <hr>

                    <h5>Location Details</h5>

                    <p>
                        Area: {{ $listing->area?->name ?? 'Not specified' }}
                    </p>

                    <p>
                        City: {{ $listing->city->name }}
                    </p>

                    <p>
                        State: {{ $listing->state->name }}
                    </p>

                    <p>
                        Country: {{ $listing->country->name }}
                    </p>

                    <hr>

                    <p class="text-muted">
                        Posted {{ $listing->created_at->diffForHumans() }}
                    </p>

                </div>

            </div>

        </div>


        <!-- Seller Information -->
        <div class="col-md-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>Seller Information</h5>

                    <hr>

                    <h6>{{ $listing->user->name }}</h6>

                    <p class="text-muted">
                        Registered Marketplace User
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- Related Listings -->
    <h4 class="mb-3">Related Listings</h4>

    <div class="row">

        @forelse($relatedListings as $related)

            <div class="col-md-3 mb-3">

                <div class="card h-100">

                    <div class="card-body">

                        <h6>{{ $related->name }}</h6>

                        <h5 class="text-success">

                            @if($related->price !== null)
                                ₹{{ number_format((float) $related->price, 2) }}
                            @else
                                Price on Request
                            @endif

                        </h5>

                        <p class="small text-muted">
                            {{ $related->city->name }}
                        </p>

                        <a href="{{ route('listings.show', $related->slug) }}"
                           class="btn btn-marketplace w-100">

                            View

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <p>No related listings available.</p>

        @endforelse

    </div>

</div>

@endsection