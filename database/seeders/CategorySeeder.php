<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Mobiles' => [
                'Mobile Phones',
                'Tablets',
                'Mobile Accessories'
            ],

            'Vehicles' => [
                'Cars',
                'Bikes',
                'Scooters'
            ],

            'Property' => [
                'Apartments',
                'Houses',
                'Commercial Property'
            ],

            'Electronics' => [
                'Laptops',
                'Computers',
                'Televisions'
            ],

            'Furniture' => [
                'Sofa',
                'Beds',
                'Tables',
                'Chairs'
            ],

            'Services' => [
                'Web Development',
                'Electrician',
                'Plumber',
                'Cleaning Services'
            ],
        ];

        foreach ($categories as $categoryName => $subcategories) {

            $category = Category::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($categoryName)],
                [
                    'name' => $categoryName,
                    'is_active' => true
                ]
            );

            foreach ($subcategories as $subcategoryName) {

                Subcategory::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'slug' => \Illuminate\Support\Str::slug($subcategoryName)
                    ],
                    [
                        'name' => $subcategoryName,
                        'is_active' => true
                    ]
                );
            }
        }
    }
}