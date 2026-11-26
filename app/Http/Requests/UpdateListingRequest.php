<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'listing_type' => 'required|in:product,service',
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:5000',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
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

            if (!empty($data['subcategory_id']) &&
                !DB::table('subcategories')
                    ->where('id', $data['subcategory_id'])
                    ->where('category_id', $data['category_id'])
                    ->exists()) {
                $validator->errors()->add('subcategory_id', 'Invalid subcategory.');
            }

            if (!DB::table('states')
                ->where('id', $data['state_id'])
                ->where('country_id', $data['country_id'])
                ->exists()) {
                $validator->errors()->add('state_id', 'Invalid state.');
            }

            if (!DB::table('cities')
                ->where('id', $data['city_id'])
                ->where('state_id', $data['state_id'])
                ->exists()) {
                $validator->errors()->add('city_id', 'Invalid city.');
            }

            if (!empty($data['area_id']) &&
                !DB::table('areas')
                    ->where('id', $data['area_id'])
                    ->where('city_id', $data['city_id'])
                    ->exists()) {
                $validator->errors()->add('area_id', 'Invalid area.');
            }
        });
    }
}