@extends('layouts.app')

@section('title', 'Categories and Locations')

@section('content')

<div class="py-4">

    <h2 class="mb-4">Marketplace Master Data</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Categories and Subcategories</h5>
        </div>

        <div class="card-body">

            @foreach($categories as $category)

                <div class="mb-3">

                    <h6>{{ $category->name }}</h6>

                    @foreach($category->subcategories as $subcategory)

                        <span class="badge bg-secondary me-2">
                            {{ $subcategory->name }}
                        </span>

                    @endforeach

                </div>

                <hr>

            @endforeach

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Available Locations</h5>
        </div>

        <div class="card-body">

            @foreach($states as $state)

                <h6>{{ $state->name }}</h6>

                @foreach($state->cities as $city)

                    <p class="ms-3 mb-1">
                        <strong>{{ $city->name }}</strong>
                    </p>

                    @foreach($city->areas as $area)

                        <span class="badge bg-info text-dark ms-4 mb-2">
                            {{ $area->name }}
                        </span>

                    @endforeach

                @endforeach

                <hr>

            @endforeach

        </div>
    </div>

</div>

@endsection