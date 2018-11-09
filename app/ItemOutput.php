<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemOutput extends Model
{
    protected $fillable = [
    	'item_code',
        'item_name',
    	'item_type',
    	'quantity',
    	'uom',
    	'remarks',
        'transaction_type',
    	'create_user',
    	'update_user',
    	'deleted'
    ];
}
