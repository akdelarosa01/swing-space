<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DropdownName extends Model
{
    protected $fillable = [
		'description',
		'create_user',
		'update_user'
    ];
}
