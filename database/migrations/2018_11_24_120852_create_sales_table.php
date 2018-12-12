<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_user_id')->nullable()->default(0);
            $table->string('customer_code');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('customer_type')->length(1);
            $table->double('sub_total',12,2)->default(0.00);
            $table->double('discount',12,2)->default(0.00);
            $table->double('payment',12,2)->default(0.00);
            $table->double('change',12,2)->default(0.00);
            $table->double('total_sale',12,2)->default(0.00);
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
        Schema::dropIfExists('sales');
    }
}
