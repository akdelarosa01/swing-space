<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerProductBill extends Model
{
    protected $fillable = [
    	'customer_user_id',
    	'customer_code',
    	'firstname',
    	'lastname',
    	'customer_type',
    	'prod_code',
    	'prod_name',
    	'prod_type',
    	'variants',
    	'quantity',
    	'cost'
    ];
}
