<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    	'prod_code',
		'prod_name',
		'description',
		'prod_type',
		'price',
		'variants',
		'create_user',
		'update_user'
    ];
}
