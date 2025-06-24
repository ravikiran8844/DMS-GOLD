<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('order_no')->nullable();
            $table->longText('remarks')->nullable();
            $table->unsignedBigInteger('zone_id');
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->longText('box')->nullable();
            $table->longText('others')->nullable();
            $table->string('invoice_no')->nullable();
            $table->date('expected_delivery_date')->nullable();
            $table->string('totalweight')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->integer('is_cancel')->default(0);
            $table->string('invoice_path')->nullable();
            $table->string('invoice')->nullable();
            $table->integer('is_viewed')->default(0);
            $table->integer('is_approved')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
