<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemInput extends Model
{
    protected $fillable = [
    	'item_code',
    	'item_name',
    	'item_type',
    	'quantity',
        'uom',
    	'remarks',
        'transaction_type',
    	'date_received',
    	'exp_date',
    	'create_user',
    	'update_user',
        'deleted'
    ];
}
