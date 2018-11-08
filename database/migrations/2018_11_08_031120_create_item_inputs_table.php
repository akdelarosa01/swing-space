<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_inputs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_code');
            $table->string('item_name');
            $table->string('item_type');
            $table->double('quantity')->length(10,2)->nullable()->default('0.00');
            $table->string('uom');
            $table->text('remarks')->nullable();
            $table->string('transaction_type');
            $table->date('date_received');
            $table->date('exp_date')->nullable();
            $table->integer('create_user');
            $table->integer('update_user');
            $table->integer('deleted')->nullable()->default(0);
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
        Schema::dropIfExists('item_inputs');
    }
}
