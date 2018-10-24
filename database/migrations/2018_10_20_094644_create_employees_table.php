<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('employee_id');
            $table->date('date_of_birth');
            $table->string('phone')->default('N/A');
            $table->string('mobile')->default('N/A');
            $table->string('street');
            $table->string('state');
            $table->string('city');
            $table->string('zip');
            $table->string('position');
            $table->string('sss');
            $table->string('tin');
            $table->string('philhealth');
            $table->string('pagibig');
            $table->date('date_hired');
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
        Schema::dropIfExists('employees');
    }
}
