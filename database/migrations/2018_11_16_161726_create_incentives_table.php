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
            $table->double('price_from',12,2)->default(0.00);
            $table->double('price_to',12,2)->default(0.00);
            $table->double('points',12,2)->default(0.00);
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
