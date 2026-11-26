<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'listing_type' => [
                'required',
                Rule::in(['product', 'service'])
            ],

            'name' => 'required|string|max:255',

            'detail' => 'required|string|max:5000',

            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
                    ->where('is_active', true)
            ],

            'subcategory_id' => [
                'nullable',
                'integer',
                Rule::exists('subcategories', 'id')
                    ->where('is_active', true)
            ],

            'country_id' => 'required|exists:countries,id',

            'state_id' => 'required|exists:states,id',

            'city_id' => 'required|exists:cities,id',

            'area_id' => 'nullable|exists:areas,id',

            'price' => 'nullable|numeric|min:0|max:9999999999.99',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            $data = $this->all();

            if (
                !empty($data['subcategory_id']) &&
                !empty($data['category_id'])
            ) {
                $valid = \DB::table('subcategories')
                    ->where('id', $data['subcategory_id'])
                    ->where('category_id', $data['category_id'])
                    ->where('is_active', true)
                    ->exists();

                if (!$valid) {
                    $validator->errors()->add(
                        'subcategory_id',
                        'Selected subcategory does not belong to this category.'
                    );
                }
            }

            if (
                !empty($data['country_id']) &&
                !empty($data['state_id'])
            ) {
                $valid = \DB::table('states')
                    ->where('id', $data['state_id'])
                    ->where('country_id', $data['country_id'])
                    ->exists();

                if (!$valid) {
                    $validator->errors()->add(
                        'state_id',
                        'Selected state does not belong to this country.'
                    );
                }
            }

            if (
                !empty($data['state_id']) &&
                !empty($data['city_id'])
            ) {
                $valid = \DB::table('cities')
                    ->where('id', $data['city_id'])
                    ->where('state_id', $data['state_id'])
                    ->exists();

                if (!$valid) {
                    $validator->errors()->add(
                        'city_id',
                        'Selected city does not belong to this state.'
                    );
                }
            }

            if (!empty($data['area_id']) && !empty($data['city_id'])) {

                $valid = \DB::table('areas')
                    ->where('id', $data['area_id'])
                    ->where('city_id', $data['city_id'])
                    ->exists();

                if (!$valid) {
                    $validator->errors()->add(
                        'area_id',
                        'Selected area does not belong to this city.'
                    );
                }
            }
        });
    }
}