<?php

namespace Database\Seeders;

use App\Models\FunRunEvent;
use App\Models\FunRunCategory;
use App\Models\FunRunPeriod;
use App\Models\FunRunPrice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FunRunSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        */

        $event = FunRunEvent::updateOrCreate(
            [
                'slug' => 'himafa-fun-run-2026',
            ],
            [
                'name' => 'Farmasi Fun Run 2026',
                'description' => 'Lari bersama, sehat bersama, dan meracik sinergi bersama HIMAFA.',
                'event_date' => '2026-10-25',
                'start_time' => '06:00:00',
                'location' => 'Gorontalo',
                'registration_start' => '2026-09-01 00:00:00',
                'registration_end' => '2026-10-20 23:59:59',
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | CATEGORY
        |--------------------------------------------------------------------------
        |
        | code_min / code_max menentukan rentang 4 digit terakhir kode
        | registrasi untuk kategori tersebut (lihat FunRunController::store()).
        | Kategori yang tidak diberi code_min/code_max akan otomatis
        | memakai rentang default 1000-9999.
        |
        */

        $categories = [
            [
                'name' => '5K',
                'distance' => '5K',
                'quota' => 500,
                'code_min' => 1000,
                'code_max' => 2999,
            ],
            [
                'name' => '10K',
                'distance' => '10K',
                'quota' => 300,
                'code_min' => 3000,
                'code_max' => 3999,
            ],
        ];

        $categoryModels = [];

        foreach ($categories as $categoryData) {

            $category = FunRunCategory::updateOrCreate(
                [
                    'event_id' => $event->id,
                    'distance' => $categoryData['distance'],
                ],
                [
                    'name' => $categoryData['name'],
                    'quota' => $categoryData['quota'],
                    'code_min' => $categoryData['code_min'],
                    'code_max' => $categoryData['code_max'],
                    'is_active' => true,
                ]
            );

            $categoryModels[$categoryData['distance']] = $category;
        }

        /*
        |--------------------------------------------------------------------------
        | PERIOD
        |--------------------------------------------------------------------------
        */

       $periods = [
    [
        'name' => 'Early Bird',
        'start_at' => '2026-08-25 00:00:00',
        'end_at' => '2026-09-15 23:59:59',
        'sort_order' => 1,
        'is_active' => true,
    ],

    [
        'name' => 'Regular',
        'start_at' => '2026-09-16 00:00:00',
        'end_at' => '2026-10-05 23:59:59',
        'sort_order' => 2,
        'is_active' => false,
    ],

    [
        'name' => 'Last Call',
        'start_at' => '2026-10-06 00:00:00',
        'end_at' => '2026-10-20 23:59:59',
        'sort_order' => 3,
        'is_active' => false,
    ],
];

        $periodModels = [];

        foreach ($periods as $periodData) {

            $period = FunRunPeriod::updateOrCreate(
                [
                    'event_id' => $event->id,
                    'name' => $periodData['name'],
                ],
                [
                    'start_at' => $periodData['start_at'],
                    'end_at' => $periodData['end_at'],
                    'sort_order' => $periodData['sort_order'],

                    // Hanya satu periode boleh aktif dalam satu waktu
                    // (lihat FunRunSettingsController::togglePeriod()).
                    // Cuma "Early Bird" yang di-set aktif di sini.
                    'is_active' => $periodData['is_active'],
                ]
            );

            $periodModels[$periodData['name']] = $period;
        }

        /*
        |--------------------------------------------------------------------------
        | PRICES
        |--------------------------------------------------------------------------
        */

        $prices = [
            'Early Bird' => [
                '5K' => 75000,
                '10K' => 100000,
            ],

            'Regular' => [
                '5K' => 100000,
                '10K' => 125000,
            ],

            'Last Call' => [
                '5K' => 125000,
                '10K' => 150000,
            ],
        ];

        foreach ($prices as $periodName => $categoryPrices) {

            $period = $periodModels[$periodName];

            foreach ($categoryPrices as $distance => $price) {

                $category = $categoryModels[$distance];

                FunRunPrice::updateOrCreate(
                    [
                        'period_id' => $period->id,
                        'category_id' => $category->id,
                    ],
                    [
                        'event_id' => $event->id,
                        'price' => $price,
                        'quota' => $category->quota,
                    ]
                );
            }
        }
    }
}