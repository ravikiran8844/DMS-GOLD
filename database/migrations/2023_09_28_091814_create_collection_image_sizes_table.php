<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateCollectionImageSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_image_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('size_name');
            $table->string('height');
            $table->string('width');
        });

        Artisan::call('db:seed', [
            '--class' => 'CollectionImageSizeSeeder'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collection_image_sizes');
    }
}
