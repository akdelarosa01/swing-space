<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Customer;
use App\User;
use DB;
use Hash;

class MembershipController extends Controller
{
    protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }

    public function index()
    {
        return view('pages.customer.membership',['user_access' => $this->_global->UserAccess()]);
    }

    public function save(Request $req)
    {
        $data = [
            'msg' => 'Saving failed.',
            'status' => 'failed'
        ];

        if (isset($req->id)) {
            $this->validate($req,[
                'firstname' => 'required|string|max:25',
                'lastname' => 'required|string|max:25',
                'email' => 'required|email|string',
                'gender' => 'required|string',
                'membership_type' => 'required'
            ]);

            $user = User::find($req->id);

            $user->firstname = $req->firstname;
            $user->lastname = $req->lastname;
            $user->email = $req->email;
            $user->gender = $req->gender;

            if (isset($req->disable)) {
                $user->disable = $req->disable;
            }

            if ($user->update()) {
                Customer::where('user_id',$req->id)->update([
                                'phone' => $req->phone,
                                'mobile' => $req->mobile,
                                'facebook' => $req->facebook,
                                'instagram' => $req->instagram,
                                'twitter' => $req->twitter,
                                'occupation' => $req->occupation,
                                'company' => $req->company,
                                'school' => $req->school,
                                'membership_type' => $req->membership_type,
                                'update_user' => Auth::user()->id,
                                'updated_at' => date('Y-m-d h:i:s')
                            ]);
            }

            $data = [
                'msg' => 'Successfully saved.',
                'status' => 'success'
            ];
            
        } else {
            $this->validate($req,[
                'firstname' => 'required|string|max:25',
                'lastname' => 'required|string|max:25',
                'email' => 'required|unique:users|email|string',
                'gender' => 'required|string',
                'membership_type' => 'required'
            ]);

            $user = new User;

            $user->firstname = $req->firstname;
            $user->lastname = $req->lastname;
            $user->email = $req->email;
            $user->password = Hash::make($req->lastname.date('ymd'));
            $user->actual_password = $req->lastname.date('ymd');
            $user->gender = $req->gender;

            if (isset($req->disable)) {
                $user->disable = $req->disable;
            }

            if ($user->save()) {
                Customer::create([
                    'user_id' => $user->id,
                    'customer_code' => 'SS1810-00001'.$req->membership_type,
                    'phone' => $req->phone,
                    'mobile' => $req->mobile,
                    'facebook' => $req->facebook,
                    'instagram' => $req->instagram,
                    'twitter' => $req->twitter,
                    'occupation' => $req->occupation,
                    'company' => $req->company,
                    'school' => $req->school,
                    'membership_type' => $req->membership_type,
                    'date_registered' => date('Y-m-d'),
                    'create_user' => Auth::user()->id,
                    'update_user' => Auth::user()->id,
                ]);
            }

            $data = [
                'msg' => 'Successfully saved.',
                'status' => 'success'
            ];
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
                            DB::raw('c.membership_type as membership_type'),
                            DB::raw('c.date_registered as date_registered')
                        )
                        ->first();

        return view('pages.customer.membership',[
            'user_access' => $this->_global->UserAccess(),
            'c' => $customer
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
