<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\UserLogsController;
use App\Customer;
use App\Incentive;
use App\User;
use DB;
use App;
use Hash;

class MembershipController extends Controller
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
        if ($this->_global->checkAccess('CUS_MEM')) {
            return view('pages.customer.membership',[
                'user_access' => $this->_global->UserAccess()
            ]);
        } else {
            return redirect('/dashboard');
        }
    }

    public function save(Request $req)
    {
        $data = [
            'msg' => 'Saving failed.',
            'status' => 'failed',
            'customer' => ''
        ];

        if (isset($req->id)) {
            $this->validate($req,[
                'firstname' => 'required|string|max:25',
                'lastname' => 'required|string|max:25',
                'email' => 'required|email|string',
                'gender' => 'required|string',
                'date_of_birth' => 'required',
            ]);

            $user = User::find($req->id);

            $user->firstname = $req->firstname;
            $user->lastname = $req->lastname;
            $user->email = $req->email;
            $user->gender = $req->gender;
            $user->user_type = 'Customer';

            if (isset($req->disabled)) {
                $user->disabled = 1;
            } else {
                $user->disabled = 0;
            }

            if ($user->update()) {
                Customer::where('user_id',$req->id)->update([
                    'date_of_birth' => $req->date_of_birth,
                    'phone' => $req->phone,
                    'mobile' => $req->mobile,
                    'facebook' => $req->facebook,
                    'instagram' => $req->instagram,
                    'twitter' => $req->twitter,
                    'occupation' => $req->occupation,
                    'company' => $req->company,
                    'school' => $req->school,
                    'referrer' => $req->referrer,
                    'membership_type' => (!isset($req->referrer) || $req->referrer == '' || $req->referrer == 0)? 'A' : 'B',
                    'update_user' => Auth::user()->id,
                    'updated_at' => date('Y-m-d h:i:s')
                ]);

                $checkRefferer = Customer::where('user_id',$req->id)
                                        ->select('referrer')->first();

                if ($checkRefferer->referrer == $req->referrer) {
                    # code...
                } else {
                    // $inc = Incentive::where([
                    //         ['inc_hrs',0],
                    //         ['inc_days',0]
                    //     ])
                    //     ->select('inc_points')->first();

                    // Customer::where('user_id',$req->referrer)->increment(
                    //     'points', $inc->inc_points,[
                    //         'update_user' => Auth::user()->id,
                    //         'updated_at' => date('Y-m-d h:i:s')
                    //     ]
                    // );
                }

                
            }

            $data = [
                'msg' => 'Successfully saved.',
                'status' => 'success',
                'customer' => $this->customer($req->id)
            ];

            $this->_userlog->log([
                'module' => 'Customer Membership',
                'action' => 'Updated Customer user ID '.$req->id.', Name '.$user->firstname.' '.$user->lastname,
                'user_id' => Auth::user()->id
            ]);
        } else {
            $this->validate($req,[
                'firstname' => 'required|string|max:25',
                'lastname' => 'required|string|max:25',
                'email' => 'required|unique:users|email|string',
                'gender' => 'required|string',
                'date_of_birth' => 'required',
            ]);

            $check = User::where([
                        ['firstname', $req->firstname],
                        ['lastname', $req->lastname],
                        ['user_type', 'Customer'],
                        ['disabled', '=', 0]
                    ])->count();

            if ($check > 0) {
                return response()->json([
                    'errors' => [
                        'firstname' => 'This customer is already registered.',
                        'lastname' => 'This customer is already registered.'
                    ]
                ], 422);
            } else {
                $pass = $this->_global->convertDate($req->date_of_birth,'Ymd');

                $user = new User;

                $user->firstname = $req->firstname;
                $user->lastname = $req->lastname;
                $user->email = $req->email;
                $user->password = Hash::make($pass);
                $user->actual_password = $pass;
                $user->gender = $req->gender;
                $user->user_type = 'Customer';

                if (isset($req->disabled)) {
                    $user->disabled = 1;
                } else {
                    $user->disabled = 0;
                }

                if ($user->save()) {
                    Customer::create([
                        'user_id' => $user->id,
                        'date_of_birth' => $req->date_of_birth,
                        'customer_code' => $this->_global->TransactionNo('CUS_CODE'),
                        'phone' => ($req->phone == '' || $req->phone == null)? 'N/A' : $req->phone,
                        'mobile' => ($req->mobile == '' || $req->mobile == null)? 'N/A' : $req->mobile,
                        'facebook' => ($req->facebook == '' || $req->facebook == null)? 'N/A' : $req->facebook,
                        'instagram' => ($req->instagram == '' || $req->instagram == null)? 'N/A' : $req->instagram,
                        'twitter' => ($req->twitter == '' || $req->twitter == null)? 'N/A' : $req->twitter,
                        'occupation' => ($req->occupation == '' || $req->occupation == null)? 'N/A' : $req->occupation,
                        'company' => ($req->company == '' || $req->company == null)? 'N/A' : $req->company,
                        'school' => ($req->school == '' || $req->school == null)? 'N/A' : $req->school,
                        'referrer' => $req->referrer,
                        'membership_type' => (!isset($req->referrer) || $req->referrer == '' || $req->referrer == 0)? 'A' : 'B',
                        'date_registered' => date('Y-m-d'),
                        'create_user' => Auth::user()->id,
                        'update_user' => Auth::user()->id,
                    ]);

                    $inc = Incentive::where([
                                ['inc_hrs',0],
                                ['inc_days',0]
                            ])
                            ->select('inc_points')->first();

                    Customer::where('user_id',$req->referrer)->increment(
                        'points', $inc->inc_points,[
                            'update_user' => Auth::user()->id,
                            'updated_at' => date('Y-m-d h:i:s')
                        ]
                    );
                }

                $this->_userlog->log([
                    'module' => 'Customer Membership',
                    'action' => 'Added Customer user ID '.$user->id.', Name '.$user->firstname.' '.$user->lastname,
                    'user_id' => Auth::user()->id
                ]);

                $data = [
                    'msg' => 'Successfully saved.',
                    'status' => 'success',
                    'customer' => $this->customer($user->id)
                ];
            }
        }

        return response()->json($data);
    }

    public function edit($id)
    {
        $customer = DB::table('users as u')
                        ->join('customers as c','u.id','=','c.user_id')
                        ->where('u.id',$id)
                        ->select(
                            DB::raw('u.id as id'),
                            DB::raw('u.photo as photo'),
                            DB::raw('u.firstname as firstname'),
                            DB::raw('u.lastname as lastname'),
                            DB::raw('u.email as email'),
                            DB::raw('u.gender as gender'),
                            DB::raw('c.customer_code as customer_code'),
                            DB::raw('c.phone as phone'),
                            DB::raw('c.mobile as mobile'),
                            DB::raw('c.facebook as facebook'),
                            DB::raw('c.instagram as instagram'),
                            DB::raw('c.twitter as twitter'),
                            DB::raw('c.occupation as occupation'),
                            DB::raw('c.company as company'),
                            DB::raw('c.school as school'),
                            DB::raw('c.date_of_birth as date_of_birth'),
                            DB::raw('c.referrer as referrer_id'),
                            DB::raw('c.membership_type as membership_type'),
                            DB::raw('c.date_registered as date_registered')
                        )
                        ->first();

        return view('pages.customer.membership',[
            'user_access' => $this->_global->UserAccess(),
            'id' => $id
        ]);
    }

    public function show(Request $req)
    {
        return response()->json($this->customer($req->id));
    }

    public function customer($id)
    {
        $customer = DB::table('users as u')
                        ->join('customers as c','u.id','=','c.user_id')
                        ->where('u.id',$id)
                        ->select(
                            DB::raw('u.id as id'),
                            DB::raw('u.photo as photo'),
                            DB::raw('u.firstname as firstname'),
                            DB::raw('u.lastname as lastname'),
                            DB::raw('u.email as email'),
                            DB::raw('u.gender as gender'),
                            DB::raw('c.customer_code as customer_code'),
                            DB::raw('c.phone as phone'),
                            DB::raw('c.mobile as mobile'),
                            DB::raw('c.facebook as facebook'),
                            DB::raw('c.instagram as instagram'),
                            DB::raw('c.twitter as twitter'),
                            DB::raw('c.occupation as occupation'),
                            DB::raw('c.company as company'),
                            DB::raw('c.school as school'),
                            DB::raw('c.date_of_birth as date_of_birth'),
                            DB::raw('c.referrer as referrer_id'),
                            DB::raw('c.membership_type as membership_type'),
                            DB::raw('c.date_registered as date_registered')
                        )
                        ->first();
        return $customer;
    }

    public function destroy($id)
    {
        //
    }
}
