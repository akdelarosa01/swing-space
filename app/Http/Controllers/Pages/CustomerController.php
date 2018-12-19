<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\SuperAdmin\UserLogsController;
use App\User;
use App\Customer;
use DB;

class CustomerController extends Controller
{
    protected $_global;
    protected $_userlog;

    public function __construct()
    {
        $this->_global = new GlobalController;
        $this->_userlog = new UserLogsController;
    }

    public function index()
    {
        if ($this->_global->checkAccess('CUS_LST')) {
            return view('pages.customer.customer_list',[
                'user_access' => $this->_global->UserAccess()
            ]);
        } else {
            return redirect('/dashboard');
        }
    }

    public function show()
    {
        $customers = DB::table('users as u')
                        ->join('customers as c','u.id','=','c.user_id')
                        ->where('u.disabled',0)
                        ->orderBy('u.id')
                        ->select(
                            DB::raw('u.id as id'),
                            DB::raw('u.photo as photo'),
                            DB::raw('u.firstname as firstname'),
                            DB::raw('u.lastname as lastname'),
                            DB::raw('u.email as email'),
                            DB::raw('u.gender as gender'),
                            DB::raw('c.customer_code as customer_code'),
                            DB::raw('date_format(c.date_of_birth,"%b %d, %Y") as date_of_birth'),
                            DB::raw('c.phone as phone'),
                            DB::raw('c.mobile as mobile'),
                            DB::raw('c.facebook as facebook'),
                            DB::raw('c.instagram as instagram'),
                            DB::raw('c.twitter as twitter'),
                            DB::raw('c.occupation as occupation'),
                            DB::raw('c.company as company'),
                            DB::raw('c.school as school'),
                            DB::raw("(select ifnull(concat(us.firstname,' ',us.lastname),'N/A')
                                    from users as us where us.id = c.referrer) as referrer"),
                            DB::raw('c.points as points'),
                            DB::raw('c.membership_type as membership_type'),
                            DB::raw('date_format(c.date_registered,"%b %d, %Y") as date_registered')
                        )
                        ->get();
        return response()->json($customers);
    }

    public function destroy(Request $req)
    {
        $data = [
            'msg' => 'Deleting failed.',
            'status' => 'failed',
            'customers' => ''
        ];

        if (isset($req->id)) {

            $cust = Customer::where('user_id',$req->id)->first();

            $this->_userlog->log([
                'module' => 'Customer List',
                'action' => 'Delete Customer code: '.$cust->customer_code.', User ID: '.$req->id,
                'user_id' => Auth::user()->id
            ]);

            $user = User::find($req->id);
            $user->disabled = 1;
            if ($user->update()) {
                $customers = DB::table('users as u')
                        ->join('customers as c','u.id','=','c.user_id')
                        ->where('u.disabled',0)
                        ->orderBy('u.id')
                        ->select(
                            DB::raw('u.id as id'),
                            DB::raw('u.photo as photo'),
                            DB::raw('u.firstname as firstname'),
                            DB::raw('u.lastname as lastname'),
                            DB::raw('u.email as email'),
                            DB::raw('u.gender as gender'),
                            DB::raw('c.customer_code as customer_code'),
                            DB::raw('date_format(c.date_of_birth,"%b %d, %Y") as date_of_birth'),
                            DB::raw('c.phone as phone'),
                            DB::raw('c.mobile as mobile'),
                            DB::raw('c.facebook as facebook'),
                            DB::raw('c.instagram as instagram'),
                            DB::raw('c.twitter as twitter'),
                            DB::raw('c.occupation as occupation'),
                            DB::raw('c.company as company'),
                            DB::raw('c.school as school'),
                            DB::raw("(select ifnull(concat(us.firstname,' ',us.lastname),'N/A')
                                    from users as us where us.id = c.referrer) as referrer"),
                            DB::raw('c.points as points'),
                            DB::raw('c.membership_type as membership_type'),
                            DB::raw('date_format(c.date_registered,"%b %d, %Y") as date_registered')
                        )
                        ->get();

                $data = [
                    'msg' => 'Successfully deleted.',
                    'status' => 'success',
                    'customers' => $customers
                ];
            }
        }

        return response()->json($data);
    }
}
