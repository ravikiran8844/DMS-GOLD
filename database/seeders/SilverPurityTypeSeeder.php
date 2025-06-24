<?php

namespace Database\Seeders;

use App\Models\SilverPurity;
use Illuminate\Database\Seeder;

class SilverPurityTypeSeeder extends Seeder
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
                'silver_purity_name' => 'Fine Silver',
                'silver_purity_percentage' => '99.9%'
            ],
            [
                'silver_purity_name' => 'Britannia silver',
                'silver_purity_percentage' => '95.8%'
            ],
            [
                'silver_purity_name' => 'Sterling silver',
                'silver_purity_percentage' => '92.5%'
            ],
            [
                'silver_purity_name' => 'Argentium silver',
                'silver_purity_percentage' => '93.5%'
            ]
        ];

        SilverPurity::Insert($data);
    }
}
