<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPoint extends Model
{
    protected $fillable = [
    	'customer_id',
    	'inc_code',
    	'inc_name',
    	'inc_points'
    ];
}
