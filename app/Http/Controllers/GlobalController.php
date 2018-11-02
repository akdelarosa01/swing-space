<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Module;
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

    public function getModules()
    {
        $modules = Module::all();
        return response()->json($modules);
    }

    public function getProvince()
    {
        $province = DB::table('refprovince')->get();
        return response()->json($province);
    }

    public function getCity(Request $req)
    {
        $province = DB::table('refcitymun')->where('provCode',$req->prov_code)->get();
        return response()->json($province);
    }

    public function uploadPhoto($id,$photo,$foldername)
    {
        if (isset($photo)) {
            $dbPath = 'img/'.$foldername.'/';
            $destinationPath = public_path($dbPath);
            $fileName = 'img_'.$id.'.'.$photo->getClientOriginalExtension();

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            if (File::exists($destinationPath.'/'.$fileName)) {
                File::delete($destinationPath.'/'.$fileName);
            }

            $photo->move($destinationPath, $fileName);

            $user = User::find($id);
            $user->photo = $dbPath.$fileName;
            $user->update();
        }
    }
}
