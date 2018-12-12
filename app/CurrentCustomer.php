<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrentCustomer extends Model
{
    protected $fillable = [
    	'customer_user_id',
    	'cust_code',
    	'cust_firstname',
    	'cust_lastname',
    	'customer_type',
    	'create_user',
    	'update_user'
    ];
}
