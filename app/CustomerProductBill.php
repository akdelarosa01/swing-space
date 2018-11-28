<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerProductBill extends Model
{
    protected $fillable = [
    	'customer_id',
    	'prod_code',
    	'prod_name',
    	'prod_type',
    	'variants',
    	'quantity',
    	'cost'
    ];
}
