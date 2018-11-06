<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    	'product_code',
		'product_name',
		'product_description',
		'product_type',
		'variants',
		'unit_price',
		'create_user',
		'update_user'
    ];
}
