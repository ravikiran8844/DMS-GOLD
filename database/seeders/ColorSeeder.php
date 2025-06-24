<?php

namespace Database\Seeders;

use App\Models\Color;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
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
                'color_name' => 'white',
                'is_active' => '1',
                'created_by' => '2',
                'updated_by' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        Color::Insert($data);
    }
}
