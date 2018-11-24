<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerLog extends Model
{
    protected $fillable = [
    	'customer_id',
    	'date_logged',
    	'time_in',
    	'time_out',
    	'hrs'
    ];
}
