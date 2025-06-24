<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('qty');
            $table->unsignedBigInteger('size_id')->nullable();
            $table->foreign('size_id')->references('id')->on('sizes');
            $table->integer('weight')->nullable();
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('id')->on('colors');
            $table->unsignedBigInteger('plating_id');
            $table->foreign('plating_id')->references('id')->on('platings');
            $table->string('remarks')->nullable();
            $table->integer('box_id')->nullable();
            $table->string('box_details')->nullable();
            $table->string('others')->nullable();
            $table->string('reference')->nullable();
            $table->integer('is_ready_stock')->default(0);
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
        Schema::dropIfExists('carts');
    }
}
