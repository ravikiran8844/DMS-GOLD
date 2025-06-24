<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_unique_id');
            $table->string('product_name')->nullable();
            $table->string('product_image')->nullable();
            $table->float('product_price', 8, 2)->default(0);
            $table->date('designed_date')->nullable();
            $table->date('design_updated_date')->nullable();
            $table->integer('height')->nullable();
            $table->integer('depth')->nullable();
            $table->integer('density')->nullable();
            $table->integer('width')->nullable();
            $table->float('weight');
            $table->string('product_carat')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->foreign('color_id')->references('id')->on('colors');
            $table->unsignedBigInteger('style_id')->nullable();
            $table->foreign('style_id')->references('id')->on('styles');
            $table->unsignedBigInteger('finish_id');
            $table->foreign('finish_id')->references('id')->on('finishes');
            $table->unsignedBigInteger('size_id')->nullable();
            $table->foreign('size_id')->references('id')->on('sizes');
            $table->string('finishing')->nullable();
            $table->string('shape')->nullable();
            $table->unsignedBigInteger('plating_id')->nullable();
            $table->foreign('plating_id')->references('id')->on('platings');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->unsignedBigInteger('metal_type_id')->nullable();
            $table->foreign('metal_type_id')->references('id')->on('metal_types');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->string('base_product')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
            $table->unsignedBigInteger('zone_id');
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->unsignedBigInteger('collection_id')->nullable();
            $table->foreign('collection_id')->references('id')->on('collections');
            $table->unsignedBigInteger('sub_collection_id')->nullable();
            $table->foreign('sub_collection_id')->references('id')->on('sub_collections');
            $table->unsignedBigInteger('jewel_type_id')->nullable();
            $table->foreign('jewel_type_id')->references('id')->on('jewel_types');
            $table->unsignedBigInteger('purity_id')->nullable();
            $table->foreign('purity_id')->references('id')->on('silver_purities');
            $table->string('making_percent')->nullable();
            $table->string('moq')->nullable();
            $table->string('hallmarking')->nullable();
            $table->string('crwcolcode')->nullable();
            $table->string('crwsubcolcode')->nullable();
            $table->string('gender')->nullable();
            $table->integer('cwqty')->default(0);
            $table->integer('qty')->default(0);
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('net_weight')->nullable();
            $table->string('keywordtags')->nullable();
            $table->float('otherrate', 8, 2)->default(0);
            $table->integer('is_active')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
