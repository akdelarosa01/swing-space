<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralPoint extends Model
{
    protected $fillable = [
    	'description',
    	'points',
    	'create_user',
    	'update_user',
    ];
}
