<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
                'category_name' => 'category 1',
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 2,
                'updated_by' => 2
            ]
        ];

        Category::Insert($data);
    }
}
