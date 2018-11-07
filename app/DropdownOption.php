<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DropdownOption extends Model
{
    protected $fillable = [
    	'dropdown_id',
		'description',
		'create_user',
		'update_user'
    ];
}
