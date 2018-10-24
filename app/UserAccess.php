<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    protected $fillable = [
    	'module_id',
		'user_id',
		'access',
		'create_user',
		'update_user'
    ];
}
