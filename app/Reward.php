<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
    	'rwd_code',
    	'rwd_name',
    	'rwd_points',
    	'rwd_hrs',
    	'rwd_space',
    	'rwd_description',
    	'create_user',
    	'update_user'
    ];
}
