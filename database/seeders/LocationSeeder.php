<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Area;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $country = Country::updateOrCreate(
            ['slug' => 'india'],
            [
                'name' => 'India',
                'code' => 'IN'
            ]
        );

        $locations = [

            'Madhya Pradesh' => [
                'Katni' => [
                    'Barhi Road',
                    'Main Market'
                ],
                'Bhopal' => [
                    'MP Nagar',
                    'Arera Colony'
                ],
                'Indore' => [
                    'Vijay Nagar',
                    'Palasia'
                ],
            ],

            'Uttar Pradesh' => [
                'Kanpur' => [
                    'Swaroop Nagar',
                    'Kakadeo'
                ],
                'Lucknow' => [
                    'Gomti Nagar',
                    'Hazratganj'
                ],
            ],

            'Karnataka' => [
                'Bangalore' => [
                    'Whitefield',
                    'Electronic City'
                ],
            ],
        ];

        foreach ($locations as $stateName => $cities) {

            $state = State::updateOrCreate(
                [
                    'country_id' => $country->id,
                    'slug' => Str::slug($stateName)
                ],
                [
                    'name' => $stateName
                ]
            );

            foreach ($cities as $cityName => $areas) {

                $city = City::updateOrCreate(
                    [
                        'state_id' => $state->id,
                        'slug' => Str::slug($cityName)
                    ],
                    [
                        'country_id' => $country->id,
                        'name' => $cityName
                    ]
                );

                foreach ($areas as $areaName) {

                    Area::updateOrCreate(
                        [
                            'city_id' => $city->id,
                            'slug' => Str::slug($areaName)
                        ],
                        [
                            'name' => $areaName
                        ]
                    );
                }
            }
        }
    }
}