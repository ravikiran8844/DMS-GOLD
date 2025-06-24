<?php

namespace Database\Seeders;

use App\Models\MakingCharge;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MakingChargeSeeder extends Seeder
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
                'mc_code' => 'A',
                'mc_charge' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mc_code' => 'B',
                'mc_charge' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mc_code' => 'C',
                'mc_charge' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mc_code' => 'D',
                'mc_charge' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mc_code' => 'E',
                'mc_charge' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mc_code' => 'F',
                'mc_charge' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mc_code' => 'G',
                'mc_charge' => 7,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mc_code' => 'H',
                'mc_charge' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mc_code' => 'I',
                'mc_charge' => 9,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mc_code' => '*',
                'mc_charge' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mc_code' => '#',
                'mc_charge' => 0.25,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mc_code' => '!',
                'mc_charge' => 0.50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mc_code' => '@',
                'mc_charge' => 0.75,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        MakingCharge::insert($data);
    }
}
