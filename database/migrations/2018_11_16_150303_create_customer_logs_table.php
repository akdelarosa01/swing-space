<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->date('date_logged');
            $table->time('time_in');
            $table->time('time_out')->nullable();
            $table->double('hrs',12,2)->default(0.00);
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
        Schema::dropIfExists('customer_logs');
    }
}
