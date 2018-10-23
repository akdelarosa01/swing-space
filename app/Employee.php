<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
    	'user_id',
		'employee_id',
		'date_of_birth',
		'gender',
		'phone',
		'mobile',
		'street',
		'state',
		'city',
		'zip',
		'position',
		'sss',
		'tin',
		'philhealth',
		'pagibig',
		'date_hired'
    ];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
