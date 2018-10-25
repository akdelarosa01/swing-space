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
            $table->string('phone')->nullable()->default('N/A');
            $table->string('mobile')->nullable()->default('N/A');
            $table->string('street')->nullable()->default('N/A');
            $table->string('state')->nullable()->default('N/A');
            $table->string('city')->nullable()->default('N/A');
            $table->string('zip')->nullable()->default('N/A');
            $table->string('position')->nullable()->default('N/A');
            $table->string('sss')->nullable()->default('N/A');
            $table->string('tin')->nullable()->default('N/A');
            $table->string('philhealth')->nullable()->default('N/A');
            $table->string('pagibig')->nullable()->default('N/A');
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
