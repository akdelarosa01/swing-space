<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class GlobalController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function UserAccess()
    {
    	$user_access = DB::table('modules as m')
    						->join('user_accesses as u','u.module_id','=','m.id')
    						->where('u.user_id',Auth::user()->id)
    						->select(
    							DB::raw('m.module_code as module_code'),
    							DB::raw('m.module_name as module_name'),
    							DB::raw('m.module_category as module_category'),
    							DB::raw('m.icon as icon'),
    							DB::raw('u.access as access')
    						)
    						->get();
    	return $user_access;
    }
}
