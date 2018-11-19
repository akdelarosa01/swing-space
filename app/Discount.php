<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
    	'description',
    	'percentage',
    	'create_user',
    	'update_user'
    ];
}
