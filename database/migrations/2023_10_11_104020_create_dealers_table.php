<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('company_name')->nullable();
            $table->longText('communication_address')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('a_name')->nullable();
            $table->string('a_designation')->nullable();
            $table->string('a_mobile')->nullable();
            $table->string('a_email')->nullable();
            $table->string('b_name')->nullable();
            $table->string('b_designation')->nullable();
            $table->string('b_mobile')->nullable();
            $table->string('b_email')->nullable();
            $table->string('gst')->nullable();
            $table->string('income_tax_pan')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('address')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_type')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('cheque_leaf')->nullable();
            $table->string('gst_certificate')->nullable();
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
        Schema::dropIfExists('dealers');
    }
}
