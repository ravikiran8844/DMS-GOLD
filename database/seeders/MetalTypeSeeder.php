<?php

namespace Database\Seeders;

use App\Models\MetalType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MetalTypeSeeder extends Seeder
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
                'metal_name' => 'metal 1',
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 2,
                'updated_by' => 2
            ]
        ];

        MetalType::Insert($data);
    }
}
