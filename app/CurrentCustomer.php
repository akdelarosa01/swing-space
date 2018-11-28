<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrentCustomer extends Model
{
    protected $fillable = [
    	'cust_code',
    	'cust_firstname',
    	'cust_lastname',
    	'cust_timein',
    	'create_user',
    	'update_user'
    ];
}
