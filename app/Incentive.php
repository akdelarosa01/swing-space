<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incentive extends Model
{
    protected $fillable = [
    	'price_from',
        'price_to',
        'points',
        'create_user',
        'update_user'
    ];
}
