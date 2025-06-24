<?php

namespace Database\Seeders;

use App\Models\BannerPosition;
use Illuminate\Database\Seeder;

class BannerPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'banner_position' => 'up',
                'height' => 716,
                'width' => 3040,
            ],
            [
                'banner_position' => 'down',
                'height' => 1276,
                'width' => 3042,
            ],
            [
                'banner_position' => 'shop',
                'height' => 153,
                'width' => 1423,
            ]

        ];

        BannerPosition::insert($data);
    }
}
