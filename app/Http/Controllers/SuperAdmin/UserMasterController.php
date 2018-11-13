<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\User;
use App\Customer;
use App\Employee;
use Hash;

class UserMasterController extends Controller
{
    protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }

    public function index()
    {
        return view('super_admin.user_master',[
                'user_access' => $this->_global->UserAccess()
            ]);
    }

    public function save(Request $req)
    {
        $data = [
            'msg' => 'Saving failed.',
            'status' => 'failed',
            'users' => ''
        ];

        if (isset($req->id)) {
            $this->validate($req,[
                'firstname' => 'required',
                'lastname' => 'required',
                'gender' => 'required',
                'date_of_birth' => 'required',
                'user_type' => 'required',
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::find($req->id);

            $user->firstname = $req->firstname;
            $user->lastname = $req->lastname;
            $user->gender = $req->gender;
            $user->user_type = $req->user_type;
            $user->email = $req->email;

            if (isset($req->password)) {
                $user->password = Hash::make($req->password);
                $user->actual_password = $req->password;
            }

            if ($user->update()) {
                if ($req->user_type == 'Customer') {
                    $this->toCustomer($user->id,$req->date_of_birth);
                } else {
                    $this->toEmployee($user->id,$req->date_of_birth);
                }

                $data = [
                    'msg' => 'Successfully saved.',
                    'status' => 'success',
                    'users' => $this->users()
                ];
            }
        } else {
            $this->validate($req,[
                'firstname' => 'required',
                'lastname' => 'required',
                'gender' => 'required',
                'date_of_birth' => 'required',
                'user_type' => 'required',
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = new User;

            $user->firstname = $req->firstname;
            $user->lastname = $req->lastname;
            $user->gender = $req->gender;
            $user->user_type = $req->user_type;
            $user->email = $req->email;
            $user->password = Hash::make($req->password);
            $user->actual_password = $req->password;

            if ($user->save()) {
                if ($req->user_type == 'Employee') {
                    $this->toCustomer($user->id,$req->date_of_birth);
                } else {
                    $this->toEmployee($user->id,$req->date_of_birth);
                }

                $data = [
                    'msg' => 'Successfully saved.',
                    'status' => 'success',
                    'users' => $this->users()
                ];
            }
        }

        return response()->json($data);
    }

    public function toCustomer($id,$bdate)
    {
        $emp = Employee::where('user_id',$id)->count();

        if ($emp) {
            Employee::where('user_id',$id)->delete();
        }

        Customer::create([
            'user_id' => $id,
            'customer_code' => $this->_global->TransactionNo('CUS_CODE'),
            'date_of_birth' => $bdate,
            'membership_type' => 'A',
            'date_registered' => date('Y-m-d'),
            'create_user' => Auth::user()->id,
            'update_user' => Auth::user()->id,
        ]);
    }

    public function toEmployee($id,$bdate)
    {
        $cus = Customer::where('user_id',$id)->count();

        if ($cus) {
            Customer::where('user_id',$id)->delete();
        }

        Employee::create([
            'user_id' => $id,
            'emp_id' => $this->_global->TransactionNo('EMP_ID'),
            'date_of_birth' => $bdate,
            'position' => 'Staff',
            'create_user' => Auth::user()->id,
            'update_user' => Auth::user()->id,
        ]);
    }

    public function show()
    {
        $user = User::orderBy('id','desc')->get();
        return response()->json($user);
    }

    private function users()
    {
        $user = User::orderBy('id','desc')->get();
        return $user;
    }

    public function destroy(Request $req)
    {
        $mod = Module::find($req->id);
        $mod->delete();

        $mods = Module::orderBy('id','desc')->get();
        return response()->json($mods);
    }
}
