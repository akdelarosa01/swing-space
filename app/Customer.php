<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
    	'user_id',
		'customer_code',
		'gender',
		'phone',
		'mobile',
		'facebook',
		'instagram',
		'twitter',
		'occupation',
		'school',
		'workplace',
		'membership_type',
		'date_registered'
    ];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
