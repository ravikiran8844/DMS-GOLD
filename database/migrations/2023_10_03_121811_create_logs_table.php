<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_name')->nullable();
            $table->string('mode')->nullable();
            $table->longText('log_message')->nullable();
            $table->integer('user_id')->default(0);
            $table->string('ip_address')->nullable();
            $table->string('system_name')->nullable();
            $table->string('is_app')->nullable();
            $table->timestamp('log_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
