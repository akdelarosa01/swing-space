<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DropdownOption extends Model
{
    protected $fillable = [
    	'dropdown_id',
		'option_description',
		'create_user',
		'update_user'
    ];
}
