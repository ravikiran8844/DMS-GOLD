<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
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
                'category_id' => 1,
                'sub_category_name' => 'sub category 1',
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 2,
                'updated_by' => 2
            ]
        ];

        SubCategory::Insert($data);
    }
}
