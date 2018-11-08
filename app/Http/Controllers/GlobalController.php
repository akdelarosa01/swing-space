<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Module;
use App\User;
use App\TransactionCode;
use App\Customer;
use Session;
use App;
use DB;

class GlobalController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function UserAccess()
    {
        $modules = DB::table('modules as m')
                    ->join('user_accesses as u','u.module_id','=','m.id')
                    ->where('u.user_id',Auth::user()->id)
                    ->select(
                        DB::raw('m.module_category as module_category'),
                        DB::raw('m.module_code as module_code'),
                        DB::raw('m.module_name as module_name'),
                        DB::raw('m.icon as icon')
                    )
                    ->get();
        return $modules;
    }

    public function checkAccess($code)
    {
        $access = DB::table('modules as m')
                    ->join('user_accesses as u','m.id','=','u.module_id')
                    ->where([
                        ['m.module_code', $code],
                        ['u.user_id', Auth::user()->id]
                    ])->count();
        return $access;
    }

    public function getLanguage()
    {
        $user = User::find(Auth::user()->id);

        $data = [
            'language' => $user->language
        ];
        return response()->json($data);
    }

    public function translateLanguage(Request $req)
    {
        $user = User::find(Auth::user()->id);

        $user->language = $req->language;

        if ($user->update()) {
            App::setLocale($req->language);
            // session(['locale', $req->language]);
            $data = [
                'language' => session('locale')
            ];
            return response()->json($data);
        }
    }

    public function getModules(Request $req)
    {
        if ($req->id == '') {
            $modules = Module::all();
        } else {
            $modules = DB::table('modules as mod')
                        ->leftJoin('user_accesses as acc', function($join) use($req) {
                            $join->on('mod.id','=','acc.module_id')->where('acc.user_id',$req->id);
                        })
                        ->select(
                            DB::raw("mod.id as id"),
                            DB::raw("mod.module_name as module_name"),
                            DB::raw("IFNULL(acc.access,0) as access")
                        )->get();
        }
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

    public function NextTransactionNo($code)
    {
        $result = '';
        $new_code = 'ERROR';

        try
        {
            $result = TransactionCode::select(
                                            DB::raw("CONCAT(prefix, LPAD(IFNULL(next_no, 0), next_no_length, '0')) AS new_code"),
                                            'next_no'
                                        )
                                        ->where('code', '=', $code)
                                        ->first();

            if(count((array)$result) <= 0)
            {
                $result->new_code = 'ERROR';
                $result->next_no = 0;
            }

            $result = TransactionCode::select(
                                            DB::raw("CONCAT(prefix, LPAD(IFNULL(next_no, 0), next_no_length, '0')) AS new_code"),
                                            'next_no'
                                        )
                                        ->where('code', '=', $code)
                                        ->first();

            if(count((array)$result) <= 0)
            {
                $result->new_code = 'ERROR';
                $result->next_no = 0;
            }
            TransactionCode::where('code', '=', $code)->update(['next_no' => $result->next_no + 1]);


        }
        catch (Exception $e)
        {
            Log::error($e->getMessage());
        }

        return $result->new_code;
    }

    public function TransactionNo($transcode)
    {
        $check = TransactionCode::where('code',$transcode)->count();
        if ($check > 0) {
            $transno = $this->NextTransactionNo($transcode);

            return $transno;
        }
    }

    public function convertDate($date,$format)
    {
        $time = strtotime($date);
        $newdate = date($format,$time);
        return $newdate;
    }

    public function referrers()
    {
        $users = DB::table('users as u')
                    ->join('customers as c','c.user_id','=','u.id')
                    ->select(
                        DB::raw("u.id as id"),
                        DB::raw("CONCAT(u.firstname,' ',u.lastname) as text")
                    )
                    ->get();
        return response()->json($users);
    }

    public function getReferrerName($id)
    {
        if (isset($id)) {
            $user = DB::table('users as u')
                        ->join('customers as c','c.user_id','=','u.id')
                        ->where('u.id',$id)
                        ->select(
                            DB::raw('u.firstname as firstname'),
                            DB::raw('u.lastname as lastname')
                        )
                        ->first();

            return $user->firstname.' '.$user->lastname;
        }
    }
}
