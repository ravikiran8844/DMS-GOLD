<?php

namespace Database\Seeders;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
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
                'project_name' => 'Test',
                'is_active' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        Project::Insert($data);
    }
}
