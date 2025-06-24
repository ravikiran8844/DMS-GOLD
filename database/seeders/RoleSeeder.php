<?php

namespace Database\Seeders;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
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
                'role_name' => 'superadmin',
                'created_by' => '1',
                'updated_by' => '1',
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
            [
                'role_name' => 'admin',
                'created_by' => '1',
                'updated_by' => '1',
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
            [
                'role_name' => 'dealer',
                'created_by' => '1',
                'updated_by' => '1',
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ]
        ];

        Role::Insert($data);
    }
}
