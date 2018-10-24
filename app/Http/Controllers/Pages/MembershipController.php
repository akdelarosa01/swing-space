<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Customer;
use App\User;

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
                'facebook' => 'string',
                'instagram' => 'string',
                'twitter' => 'string',
                'membership_type' => 'required'
            ]);

            $user = User::find($req->id);

            $user->firstname = $req->firstname;
            $user->lastname = $req->lastname;
            $user->email = $req->email;
            $user->password = Hash::make($req->lastname.date('ymd'));
            $user->actual_password = $req->lastname.date('ymd');
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
                'facebook' => 'string',
                'instagram' => 'string',
                'twitter' => 'string',
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

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
