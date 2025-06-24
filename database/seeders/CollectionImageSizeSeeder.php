<?php

namespace Database\Seeders;

use App\Models\CollectionImageSize;
use Illuminate\Database\Seeder;

class CollectionImageSizeSeeder extends Seeder
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
                'size_name' => 'horizontal',
                'height' => '357',
                'width' => '743'
            ],
            [
                'size_name' => 'vertical',
                'height' => '667',
                'width' => '476'
            ]
        ];

        CollectionImageSize::insert($data);
    }
}
