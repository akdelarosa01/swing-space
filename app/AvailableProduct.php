<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableProduct extends Model
{
    protected $fillable = [
    	'prod_id',
    	'target_qty',
    	'quantity',
    	'create_user',
    	'update_user'
    ];
}
