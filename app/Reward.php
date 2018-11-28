<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
    	'deducted_price',
        'deducted_points',
        'create_user',
        'update_user'
    ];
}
