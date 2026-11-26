@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Edit Listing</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('listings.update', $listing->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Listing Type</label>
                            <select name="listing_type" class="form-select" required>
                                <option value="product" {{ old('listing_type', $listing->listing_type) == 'product' ? 'selected' : '' }}>Product</option>
                                <option value="service" {{ old('listing_type', $listing->listing_type) == 'service' ? 'selected' : '' }}>Service</option>
                            </select>
                            @error('listing_type') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Listing Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $listing->name) }}" required>
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="detail" class="form-control" rows="4" required>{{ old('detail', $listing->detail) }}</textarea>
                            @error('detail') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $listing->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-select">
                                <option value="">Select Subcategory</option>
                                @foreach($categories as $category)
                                    @if($category->id == $listing->category_id)
                                        @foreach($category->subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                {{ old('subcategory_id', $listing->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                            @error('subcategory_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select name="country_id" id="country_id" class="form-select" required>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country_id', $listing->country_id) == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">State</label>
                            <select name="state_id" id="state_id" class="form-select" required>
                                <option value="{{ $listing->state_id }}">{{ $listing->state->name }}</option>
                            </select>
                            @error('state_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <select name="city_id" id="city_id" class="form-select" required>
                                <option value="{{ $listing->city_id }}">{{ $listing->city->name }}</option>
                            </select>
                            @error('city_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Area</label>
                            <select name="area_id" id="area_id" class="form-select">
                                <option value="">Select Area</option>
                                @if($listing->area)
                                    <option value="{{ $listing->area_id }}" selected>{{ $listing->area->name }}</option>
                                @endif
                            </select>
                            @error('area_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" min="0" name="price"
                                   class="form-control"
                                   value="{{ old('price', $listing->price) }}">
                            @error('price') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Listing</button>
                        <a href="{{ route('listings.mine') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
async function loadOptions(url, selectId, selectedId = null, placeholder = 'Select') {
    const select = document.getElementById(selectId);
    select.innerHTML = `<option value="">${placeholder}</option>`;

    if (!url) return;

    const response = await fetch(url);
    const items = await response.json();

    items.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.name;

        if (String(item.id) === String(selectedId)) {
            option.selected = true;
        }

        select.appendChild(option);
    });
}

document.getElementById('category_id').addEventListener('change', function () {
    loadOptions(
        this.value ? `/get-subcategories?category_id=${this.value}` : null,
        'subcategory_id'
    );
});

document.getElementById('country_id').addEventListener('change', function () {
    loadOptions(
        this.value ? `/get-states?country_id=${this.value}` : null,
        'state_id'
    );

    document.getElementById('city_id').innerHTML = '<option value="">Select City</option>';
    document.getElementById('area_id').innerHTML = '<option value="">Select Area</option>';
});

document.getElementById('state_id').addEventListener('change', function () {
    loadOptions(
        this.value ? `/get-cities?state_id=${this.value}` : null,
        'city_id'
    );

    document.getElementById('area_id').innerHTML = '<option value="">Select Area</option>';
});

document.getElementById('city_id').addEventListener('change', function () {
    loadOptions(
        this.value ? `/get-areas?city_id=${this.value}` : null,
        'area_id'
    );
});

</script>
@endsection