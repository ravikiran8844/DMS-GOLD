<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->integer('is_active')->default(1);
            $table->integer('otp')->nullable();
            $table->timestamp('otp_expiry')->nullable();
            $table->text('bio')->nullable();
            $table->text('user_image')->nullable();
            $table->text('address')->nullable();
            $table->text('shop_name')->nullable();
            $table->integer('preffered_dealer1')->nullable();
            $table->integer('preffered_dealer2')->nullable();
            $table->integer('preffered_dealer3')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'UserSeeder'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
