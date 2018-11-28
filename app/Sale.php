<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
    	'customer_code',
    	'sub_total',
    	'discount',
    	'payment',
    	'change',
    	'total_sale',
    	'create_user',
    	'update_user'
    ];
}
