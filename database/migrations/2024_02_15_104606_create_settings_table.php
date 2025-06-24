<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->integer('is_maintanance_mode')->default(0);
            $table->integer('otp_length')->default(0);
            $table->integer('otp_expiry_duration')->default(0);
            $table->string('company_logo')->nullable();
            $table->string('east_zone_name')->nullable();
            $table->string('east_zone_incharge_name')->nullable();
            $table->string('east_zone_mobile_no')->nullable();
            $table->string('east_zone_incharge_email')->nullable();
            $table->string('west_zone_name')->nullable();
            $table->string('west_zone_incharge_name')->nullable();
            $table->string('west_zone_mobile_no')->nullable();
            $table->string('west_zone_incharge_email')->nullable();
            $table->string('north_zone_name')->nullable();
            $table->string('north_zone_incharge_name')->nullable();
            $table->string('north_zone_mobile_no')->nullable();
            $table->string('north_zone_incharge_email')->nullable();
            $table->string('south_zone_name')->nullable();
            $table->string('south_zone_incharge_name')->nullable();
            $table->string('south_zone_mobile_no')->nullable();
            $table->string('south_zone_incharge_email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
