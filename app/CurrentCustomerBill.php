<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrentCustomerBill extends Model
{
    protected $fillable = [
    	'cust_id',
    	'prod_id',
    	'prod_code',
    	'prod_name',
    	'quantity',
    	'price',
    	'unit_price',
    	'create_user',
    	'update_user'
    ];
}
