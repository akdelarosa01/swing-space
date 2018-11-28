<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPoint extends Model
{
    protected $fillable = [
    	'customer_id',
    	'remarks',
    	'accumulated_points'
    ];
}
