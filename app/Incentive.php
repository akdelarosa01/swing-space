<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incentive extends Model
{
    protected $fillable = [
    	'inc_code',
    	'inc_name',
    	'inc_points',
    	'inc_hrs',
    	'inc_space',
    	'inc_description',
    	'create_user',
    	'update_user'
    ];
}
