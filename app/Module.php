<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
    	'module_code',
		'module_name',
		'module_category',
		'icon',
		'create_user',
		'update_user'
    ];
}
