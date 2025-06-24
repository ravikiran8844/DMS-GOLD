<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['unit_name' => 'PCS'],
            ['unit_name' => 'KG'],
            ['unit_name' => 'GM'],
            ['unit_name' => 'PAIR']
        ];

        Unit::Insert($data);
    }
}
