<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('customer_code');
            $table->date('date_of_birth');
            $table->string('phone')->nullable()->default('N/A');
            $table->string('mobile')->nullable()->default('N/A');
            $table->string('facebook')->nullable()->default('N/A');
            $table->string('instagram')->nullable()->default('N/A');
            $table->string('twitter')->nullable()->default('N/A');
            $table->string('occupation')->nullable()->default('N/A');
            $table->string('school')->nullable()->default('N/A');
            $table->string('company')->nullable()->default('N/A');
            $table->integer('referrer')->nullable()->default(0);
            $table->string('membership_type')->length(1)->default('A');
            $table->double('points',12,2)->default(0.00);
            $table->date('date_registered');
            $table->integer('create_user');
            $table->integer('update_user');
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
        Schema::dropIfExists('customers');
    }
}
