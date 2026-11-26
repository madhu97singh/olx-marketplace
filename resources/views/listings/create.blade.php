@extends('layouts.app')

@section('title', 'Add New Listing')

@section('content')

<div class="py-4">

    <div class="card shadow-sm mx-auto" style="max-width: 800px;">

        <div class="card-header bg-white p-3">
            <h4 class="mb-0">Post Your Product / Service</h4>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('listings.store') }}" method="POST">

                @csrf

                <!-- Listing Type -->
                <div class="mb-3">

                    <label class="form-label">Listing Type *</label>

                    <select name="listing_type" class="form-select">
                        <option value="">Select Type</option>
                        <option value="product" {{ old('listing_type') == 'product' ? 'selected' : '' }}>
                            Product
                        </option>
                        <option value="service" {{ old('listing_type') == 'service' ? 'selected' : '' }}>
                            Service
                        </option>
                    </select>

                    @error('listing_type')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <!-- Name -->
                <div class="mb-3">

                    <label class="form-label">Name *</label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name') }}"
                           placeholder="Enter product or service name">

                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <!-- Detail -->
                <div class="mb-3">

                    <label class="form-label">Description *</label>

                    <textarea name="detail"
                              class="form-control"
                              rows="4"
                              placeholder="Enter product or service details">{{ old('detail') }}</textarea>

                    @error('detail')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <!-- Category -->
                <div class="mb-3">

                    <label class="form-label">Category *</label>

                    <select name="category_id" id="category_id" class="form-select">

                        <option value="">Select Category</option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                    @error('category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <!-- Subcategory -->
                <div class="mb-3">

                    <label class="form-label">Subcategory</label>

                    <select name="subcategory_id" id="subcategory_id" class="form-select">

                        <option value="">Select Subcategory</option>

                    </select>

                    @error('subcategory_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <hr>

                <h5 class="mb-3">Location Details</h5>

                <!-- Country -->
                <div class="mb-3">

                    <label class="form-label">Country *</label>

                    <select name="country_id" id="country_id" class="form-select">

                        <option value="">Select Country</option>

                        @foreach($countries as $country)

                            <option value="{{ $country->id }}"
                                {{ old('country_id') == $country->id ? 'selected' : '' }}>

                                {{ $country->name }}

                            </option>

                        @endforeach

                    </select>

                    @error('country_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <!-- State -->
                <div class="mb-3">

                    <label class="form-label">State *</label>

                    <select name="state_id" id="state_id" class="form-select">

                        <option value="">Select State</option>

                    </select>

                    @error('state_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <!-- City -->
                <div class="mb-3">

                    <label class="form-label">City *</label>

                    <select name="city_id" id="city_id" class="form-select">

                        <option value="">Select City</option>

                    </select>

                    @error('city_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <!-- Area -->
                <div class="mb-3">

                    <label class="form-label">Area</label>

                    <select name="area_id" id="area_id" class="form-select">

                        <option value="">Select Area</option>

                    </select>

                    @error('area_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <hr>

                <!-- Price -->
                <div class="mb-4">

                    <label class="form-label">Price (₹)</label>

                    <input type="number"
                           name="price"
                           class="form-control"
                           value="{{ old('price') }}"
                           min="0"
                           step="0.01"
                           placeholder="Enter price">

                    @error('price')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <button type="submit" class="btn btn-marketplace w-100">
                    Submit Listing
                </button>

            </form>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script>

    // Common function to load dropdown data
    async function loadDropdown(url, parameter, value, targetId, placeholder, selectedValue = '') {

        const dropdown = document.getElementById(targetId);

        dropdown.innerHTML = `<option value="">${placeholder}</option>`;

        if (!value) {
            return;
        }

        try {

            const response = await fetch(`${url}?${parameter}=${encodeURIComponent(value)}`);

            if (!response.ok) {
                throw new Error('Unable to load data');
            }

            const data = await response.json();

            data.forEach(item => {

                const option = document.createElement('option');

                option.value = item.id;
                option.textContent = item.name;

                if (String(item.id) === String(selectedValue)) {
                    option.selected = true;
                }

                dropdown.appendChild(option);

            });

        } catch (error) {

            console.error(error);
            alert('Unable to load dropdown data. Please try again.');

        }
    }


    // Category -> Subcategory
    document.getElementById('category_id').addEventListener('change', function() {

        loadDropdown(
            '{{ route("get.subcategories") }}',
            'category_id',
            this.value,
            'subcategory_id',
            'Select Subcategory'
        );

    });


    // Country -> State
    document.getElementById('country_id').addEventListener('change', function() {

        document.getElementById('city_id').innerHTML = '<option value="">Select City</option>';
        document.getElementById('area_id').innerHTML = '<option value="">Select Area</option>';

        loadDropdown(
            '{{ route("get.states") }}',
            'country_id',
            this.value,
            'state_id',
            'Select State'
        );

    });


    // State -> City
    document.getElementById('state_id').addEventListener('change', function() {

        document.getElementById('area_id').innerHTML = '<option value="">Select Area</option>';

        loadDropdown(
            '{{ route("get.cities") }}',
            'state_id',
            this.value,
            'city_id',
            'Select City'
        );

    });


    // City -> Area
    document.getElementById('city_id').addEventListener('change', function() {

        loadDropdown(
            '{{ route("get.areas") }}',
            'city_id',
            this.value,
            'area_id',
            'Select Area'
        );

    });


    // Restore old values after validation errors
    document.addEventListener('DOMContentLoaded', async function() {

        const oldCategory = @json(old('category_id'));
        const oldSubcategory = @json(old('subcategory_id'));

        const oldCountry = @json(old('country_id'));
        const oldState = @json(old('state_id'));

        const oldCity = @json(old('city_id'));
        const oldArea = @json(old('area_id'));

        if (oldCategory) {
            await loadDropdown(
                '{{ route("get.subcategories") }}',
                'category_id',
                oldCategory,
                'subcategory_id',
                'Select Subcategory',
                oldSubcategory
            );
        }

        if (oldCountry) {
            await loadDropdown(
                '{{ route("get.states") }}',
                'country_id',
                oldCountry,
                'state_id',
                'Select State',
                oldState
            );
        }

        if (oldState) {
            await loadDropdown(
                '{{ route("get.cities") }}',
                'state_id',
                oldState,
                'city_id',
                'Select City',
                oldCity
            );
        }

        if (oldCity) {
            await loadDropdown(
                '{{ route("get.areas") }}',
                'city_id',
                oldCity,
                'area_id',
                'Select Area',
                oldArea
            );
        }

    });

</script>

@endsection