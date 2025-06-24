<?php

namespace Database\Seeders;

use App\Models\Style;
use Illuminate\Database\Seeder;

class StyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['style_name' => 'BF'],
            ['style_naem' => 'BO'],
            ['style_naem' => 'BU'],
            ['style_naem' => 'BX'],
            ['style_naem' => 'HK'],
            ['style_naem' => 'NB'],
            ['style_naem' => 'NX'],
            ['style_naem' => 'RT']
        ];

        Style::Insert($data);
    }
}
