<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rwd_code');
            $table->string('rwd_name');
            $table->double('rwd_points',12,2)->default(0.00);
            $table->integer('rwd_hrs')->default(0);
            $table->integer('rwd_days')->default(0);
            $table->string('rwd_space');
            $table->text('rwd_description');
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
        Schema::dropIfExists('rewards');
    }
}
