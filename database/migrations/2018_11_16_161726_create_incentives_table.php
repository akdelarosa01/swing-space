<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncentivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incentives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('inc_code');
            $table->string('inc_name');
            $table->double('inc_points',12,2)->default(0.00);
            $table->integer('inc_hrs')->default(0);
            $table->integer('inc_days')->default(0);
            $table->string('inc_space');
            $table->text('inc_description');
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
        Schema::dropIfExists('incentives');
    }
}
