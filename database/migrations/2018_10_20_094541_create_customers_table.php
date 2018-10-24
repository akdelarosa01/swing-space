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
            $table->string('phone')->default('N/A');
            $table->string('mobile')->default('N/A');
            $table->string('facebook')->default('N/A');
            $table->string('instagram')->default('N/A');
            $table->string('twitter')->default('N/A');
            $table->string('occupation')->default('N/A');
            $table->string('school')->default('N/A');
            $table->string('company')->default('N/A');
            $table->string('membership_type');
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
