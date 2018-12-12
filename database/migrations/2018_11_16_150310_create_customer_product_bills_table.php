<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerProductBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_product_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_user_id')->nullable()->default(0);
            $table->string('customer_code');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('prod_code');
            $table->string('prod_name');
            $table->string('prod_type');
            $table->string('variants');
            $table->integer('quantity');
            $table->double('cost',12,2);
            $table->string('customer_type')->length(1);
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
        Schema::dropIfExists('customer_product_bills');
    }
}
