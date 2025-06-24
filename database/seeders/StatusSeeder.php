<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['status' => 'starting'],
            ['status' => 'wip'],
            ['status' => 'pending'],
            ['status' => 'overdue'],
            ['status' => 'delivered']
        ];

        Status::insert($data);
    }
}
