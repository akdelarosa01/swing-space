<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
    	'item_code',
    	'item_type',
    	'quantity',
    	'minimum_stock',
    	'uom',
    	'create_user',
    	'update_user',
    	'deleted'
    ];
}
