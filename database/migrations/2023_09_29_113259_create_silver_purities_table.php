<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateSilverPuritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('silver_purities', function (Blueprint $table) {
            $table->id();
            $table->string('silver_purity_name');
            $table->string('silver_purity_percentage');
        });

        Artisan::call('db:seed', [
            '--class' => 'SilverPurityTypeSeeder'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('silver_purities');
    }
}
