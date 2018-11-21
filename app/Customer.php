<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
    	'user_id',
		'customer_code',
		'date_of_birth',
		'phone',
		'mobile',
		'facebook',
		'instagram',
		'twitter',
		'occupation',
		'school',
		'company',
		'referrer',
		'membership_type',
		'date_registered',
		'points',
		'create_user',
		'update_user'
    ];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
