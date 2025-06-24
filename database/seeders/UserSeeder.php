<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'role_id' => 1,
                'name' => 'Super Admin',
                'mobile' => '9876543210',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => 2,
                'name' => 'Admin',
                'mobile' => '9008007009',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => 3,
                'name' => 'Sundar',
                'mobile' => '7845037463',
                'email' => 'sundaram@brightbridgeinfotech.com',
                'password' => Hash::make('Coimbatore@26'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => 3,
                'name' => 'Vishnu',
                'mobile' => '9994260427',
                'email' => 'info@dvishnu.com',
                'password' => Hash::make('Coimbatore@26'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => 3,
                'name' => 'Vivin',
                'mobile' => '8220017619',
                'email' => 'vivinrajkumar.r@ejindia.com',
                'password' => Hash::make('Coimbatore@26'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        User::insert($data);
    }
}
