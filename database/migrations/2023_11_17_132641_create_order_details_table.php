<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('qty');
            $table->integer('weight');
            $table->unsignedBigInteger('size_id')->nullable();
            $table->foreign('size_id')->references('id')->on('sizes');
            $table->integer('is_delivered')->default(0);
            $table->string('tracking_no')->nullable();
            $table->string('remarks')->nullable();
            $table->string('finish')->nullable();
            $table->integer('box_id')->nullable();
            $table->string('others')->nullable();
            $table->string('box_details')->nullable();
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
        Schema::dropIfExists('order_details');
    }
}
