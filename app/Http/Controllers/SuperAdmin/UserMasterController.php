<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\User;
use App\UserAccess;
use App\Customer;
use App\Employee;
use DB;
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

            if (isset($req->disable)) {
                $user->disabled = 1;
            } else {
                $user->disabled = 0;
            }

            if ($user->update()) {
                switch ($req->user_type) {
                    case 'Customer':
                        $this->toCustomer($user->id,$req->date_of_birth,$req->id_number);
                        break;

                    case 'Employee':
                        $this->toEmployee($user->id,$req->date_of_birth,$req->id_number);
                        break;
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

            if (isset($req->disable)) {
                $user->disabled = 1;
            }

            if ($user->save()) {
                switch ($req->user_type) {
                    case 'Customer':
                        $this->toCustomer($user->id,$req->date_of_birth);
                        break;

                    case 'Employee':
                        $this->toEmployee($user->id,$req->date_of_birth);
                        break;
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

    public function toCustomer($id,$bdate,$id_number)
    {
        $emp = Employee::where('user_id',$id)->count();

        if ($emp) {
            Employee::where('user_id',$id)->delete();
        }

        $cus = Customer::where('user_id',$id)->count();

        if ($cus) {
            Customer::where('user_id',$id)
                    ->update([
                        'date_of_birth' => $bdate,
                        'customer_code' => $id_number,
                        'update_user' => Auth::user()->id
                    ]);
        } else {
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
    }

    public function toEmployee($id,$bdate,$id_number)
    {
        $cus = Customer::where('user_id',$id)->count();

        if ($cus) {
            Customer::where('user_id',$id)->delete();
        }

        $emp = Employee::where('user_id',$id)->count();

        if ($emp) {
            Employee::where('user_id',$id)
                    ->update([
                        'date_of_birth' => $bdate,
                        'employee_id' => $id_number,
                        'update_user' => Auth::user()->id
                    ]);
        } else {
            Employee::create([
                'user_id' => $id,
                'employee_id' => $this->_global->TransactionNo('EMP_ID'),
                'date_of_birth' => $bdate,
                'position' => 'Staff',
                'date_hired' => date('Y-m-d'),
                'create_user' => Auth::user()->id,
                'update_user' => Auth::user()->id,
            ]);
        }
    }

    public function show()
    {
        $user = DB::select("SELECT  u.id as id,
                                    u.firstname as firstname,
                                    u.lastname as lastname,
                                    u.gender as gender,
                                    u.user_type as user_type,
                                    u.email as email,
                                    u.actual_password as actual_password,
                                    u.disabled as disabled,
                                    CASE
                                        when (SELECT e.date_of_birth
                                                FROM employees as e
                                                where e.user_id = u.id limit 1) is not null
                                        then (SELECT e.date_of_birth
                                                FROM employees as e
                                                where e.user_id = u.id limit 1)
                                        when (SELECT c.date_of_birth
                                                FROM customers as c
                                                where c.user_id = u.id limit 1) is not null
                                        then (SELECT c.date_of_birth
                                                FROM customers as c
                                                where c.user_id = u.id limit 1)
                                        else ''
                                    END  as date_of_birth,
                                    CASE
                                        when (SELECT e.employee_id
                                                FROM employees as e
                                                where e.user_id = u.id limit 1) is not null
                                        then (SELECT e.employee_id
                                                FROM employees as e
                                                where e.user_id = u.id limit 1)
                                        when (SELECT c.customer_code
                                                FROM customers as c
                                                where c.user_id = u.id limit 1) is not null
                                        then (SELECT c.customer_code
                                                FROM customers as c
                                                where c.user_id = u.id limit 1)
                                        else ''
                                    END  as id_number
                            from users as u
                            order by u.id desc");
        return response()->json($user);
    }

    private function users()
    {
        $user = DB::select("SELECT  u.id as id,
                                    u.firstname as firstname,
                                    u.lastname as lastname,
                                    u.gender as gender,
                                    u.user_type as user_type,
                                    u.email as email,
                                    u.actual_password as actual_password,
                                    u.disabled as disabled,
                                    CASE
                                        when (SELECT e.date_of_birth
                                                FROM employees as e
                                                where e.user_id = u.id limit 1) is not null
                                        then (SELECT e.date_of_birth
                                                FROM employees as e
                                                where e.user_id = u.id limit 1)
                                        when (SELECT c.date_of_birth
                                                FROM customers as c
                                                where c.user_id = u.id limit 1) is not null
                                        then (SELECT c.date_of_birth
                                                FROM customers as c
                                                where c.user_id = u.id limit 1)
                                        else ''
                                    END  as date_of_birth,
                                    CASE
                                        when (SELECT e.employee_id
                                                FROM employees as e
                                                where e.user_id = u.id limit 1) is not null
                                        then (SELECT e.employee_id
                                                FROM employees as e
                                                where e.user_id = u.id limit 1)
                                        when (SELECT c.customer_code
                                                FROM customers as c
                                                where c.user_id = u.id limit 1) is not null
                                        then (SELECT c.customer_code
                                                FROM customers as c
                                                where c.user_id = u.id limit 1)
                                        else ''
                                    END  as id_number
                            from users as u
                            order by u.id desc");
        return $user;
    }

    public function assign_access(Request $req)
    {
        $data = [
            'msg' => 'Assigning failed.',
            'status' => 'failed'
        ];

        UserAccess::where('user_id',$req->user_id)->delete();
        $assigned = $this->give_access($req,$req->user_id);

        if ($assigned) {
            $data = [
                'msg' => 'Modules were successfully assigned.',
                'status' => 'success'
            ];
        }

        return response()->json($data);
    }

    private function give_access($req,$id)
    {
        $return = false;

        $accesses = [];

        if (isset($req->rw)) {
            foreach ($req->rw as $key => $rw) {
                array_push($accesses, [
                    'module_id' => $rw,
                    'user_id' => $id,
                    'access' => 1,
                    'create_user' => Auth::user()->id,
                    'update_user' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        if (isset($req->ro)) {
            foreach ($req->ro as $key => $ro) {
                if (in_array($ro, $req->rw)) {
                    
                } else {
                    array_push($accesses, [
                        'module_id' => $ro,
                        'user_id' => $id,
                        'access' => 2,
                        'create_user' => Auth::user()->id,
                        'update_user' => Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        $sort = [];
        $user_accesses = [];
        foreach ($accesses as $key => $row) {
            $sort[$key] = $row['module_id'];
        }

        array_multisort($sort, SORT_ASC, $accesses);

        foreach ($accesses as $key => $row) {
            array_push($user_accesses,[
                'module_id' => $row['module_id'],
                'user_id' => $row['user_id'],
                'access' => $row['access'],
                'create_user' => $row['create_user'],
                'update_user' => $row['update_user'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
            ]);
        }

        array_unique($user_accesses,SORT_REGULAR);

        $allowAccess = array_chunk($user_accesses, 1000);

        foreach ($allowAccess as $access) {
            $insert = UserAccess::insert($access);

            if ($insert) {
                $return = true;
            }
        }

        return $return;
    }

    public function destroy(Request $req)
    {
        $data = [
            'msg' => "Deleting failed",
            'status' => "warning"
        ];

        if (is_array($req->id)) {
            foreach ($req->id as $key => $id) {
                $user = User::find($id);
                $user->delete();

                $data = [
                    'msg' => "User was successfully deleted.",
                    'status' => "success",
                    'users' => $this->users()
                ];
            }
        } else {
            $user = User::find($req->id);
            $user->delete();

            $data = [
                'msg' => "User was successfully deleted.",
                'status' => "success",
                'users' => $this->users()
            ];
        }
        return response()->json($data);
    }
}
