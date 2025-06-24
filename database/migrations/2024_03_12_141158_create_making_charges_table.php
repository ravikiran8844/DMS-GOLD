<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateMakingChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('making_charges', function (Blueprint $table) {
            $table->id();
            $table->string('mc_code')->nullable();
            $table->string('mc_charge')->nullable();
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'MakingChargeSeeder'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('making_charges');
    }
}
