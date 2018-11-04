<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionCode extends Model
{
    protected $fillable = [
    	'code',
		'description',
		'prefix',
		'next_no',
		'next_no_length',
		'create_user',
		'update_user'
    ];
}
