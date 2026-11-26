
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">My Listings</h2>
            <p class="text-muted mb-0">Manage all your published listings here.</p>
        </div>

        <a href="{{ route('listings.create') }}" class="btn btn-primary">
            + Add New Listing
        </a>
    </div>

    @if($listings->count() > 0)

        <div class="row">

            @foreach($listings as $listing)

                <div class="col-md-6 col-lg-4 mb-4">

                    <div class="card h-100 shadow-sm">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <span class="badge bg-secondary">
                                    {{ ucfirst($listing->listing_type) }}
                                </span>

                                @if($listing->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($listing->status === 'inactive')
                                    <span class="badge bg-warning text-dark">Inactive</span>
                                @else
                                    <span class="badge bg-danger">Sold</span>
                                @endif

                            </div>

                            <h5 class="card-title">
                                {{ $listing->name }}
                            </h5>

                            <h5 class="text-primary mb-3">
                                @if($listing->price !== null)
                                    ₹{{ number_format($listing->price, 2) }}
                                @else
                                    Price on Request
                                @endif
                            </h5>

                            <p class="text-muted mb-2">
                                <strong>Category:</strong>
                                {{ $listing->category->name ?? 'N/A' }}
                            </p>

                            <p class="text-muted mb-2">
                                <strong>City:</strong>
                                {{ $listing->city->name ?? 'N/A' }}
                            </p>

                            <p class="text-muted mb-2">
                                <strong>Posted:</strong>
                                {{ $listing->created_at->diffForHumans() }}
                            </p>

                            <hr>

                            <div class="d-flex flex-wrap gap-2">

                                @if($listing->status === 'active')
                                    <a href="{{ route('listings.show', $listing->slug) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                @endif

                                <a href="{{ route('listings.edit', $listing->id) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('listings.status', $listing->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <select name="status"
                                            class="form-select form-select-sm"
                                            onchange="this.form.submit()">

                                        <option value="active"
                                            {{ $listing->status === 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>

                                        <option value="inactive"
                                            {{ $listing->status === 'inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>

                                        <option value="sold"
                                            {{ $listing->status === 'sold' ? 'selected' : '' }}>
                                            Sold
                                        </option>

                                    </select>
                                </form>

                                <form action="{{ route('listings.destroy', $listing->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this listing?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <div class="mt-3">
            {{ $listings->links('pagination::bootstrap-5') }}
        </div>

    @else

        <div class="card shadow-sm text-center py-5">
            <div class="card-body">

                <h4>No Listings Found</h4>

                <p class="text-muted">
                    You haven't posted any products or services yet.
                </p>

                <a href="{{ route('listings.create') }}" class="btn btn-primary">
                    Post Your First Listing
                </a>

            </div>
        </div>

    @endif

</div>
@endsection
