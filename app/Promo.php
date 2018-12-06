<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
    	'promo_photo',
    	'promo_desc',
    	'create_user',
    	'update_user',
    ];
}
