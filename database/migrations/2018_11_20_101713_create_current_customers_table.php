<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrentCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cust_code')->nullable()->default('N/A');
            $table->string('cust_firstname');
            $table->string('cust_lastname');
            $table->dateTime('cust_timein');
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
        Schema::dropIfExists('current_customers');
    }
}
