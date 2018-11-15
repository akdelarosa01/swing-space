<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $fillable = [
    	'module',
    	'action',
    	'user_id'
    ];
}
