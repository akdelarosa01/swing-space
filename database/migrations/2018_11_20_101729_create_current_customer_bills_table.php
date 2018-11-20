<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrentCustomerBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_customer_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cust_id');
            $table->integer('prod_id');
            $table->string('prod_code');
            $table->string('prod_name');
            $table->integer('quantity');
            $table->double('price',12,2);
            $table->double('unit_price',12,2);
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
        Schema::dropIfExists('current_customer_bills');
    }
}
