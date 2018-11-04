<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Employee;
use App\UserAccess;
use App\User;
use DB;
use Hash;

class EmployeeController extends Controller
{
    protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }

    public function index()
    {
        return view('pages.employee.employee-list',['user_access' => $this->_global->UserAccess()]);
    }

    public function registration($value='')
    {
        return view('pages.employee.registration',['user_access' => $this->_global->UserAccess()]);
    }

    public function save(Request $req)
    {
        $data = [
            'msg' => 'Saving failed.',
            'status' => 'failed',
            'employee' => ''
        ];

        if (isset($req->id)) {
            $this->validate($req,[
                'firstname' => 'required|string|max:25',
                'lastname' => 'required|string|max:25',
                'email' => 'required|email|string',
                'gender' => 'required|string',
                'date_of_birth' => 'required',
                'position' => 'required'
            ]);

            $user = User::find($req->id);

            $user->firstname = $req->firstname;
            $user->lastname = $req->lastname;
            $user->email = $req->email;
            $user->gender = $req->gender;

            if (isset($req->password)) {
                $user->password = Hash::make($req->password);
                $user->actual_password = $req->password;
            }

            if (isset($req->disable)) {
                $user->disable = $req->disable;
            }

            if ($user->update()) {
                Employee::where('user_id',$req->id)->update([
                    'date_of_birth' => $req->date_of_birth,
                    'phone' => ($req->phone == '' || $req->phone == null)? 'N/A' : $req->phone,
                    'mobile' => ($req->mobile == '' || $req->mobile == null)? 'N/A' : $req->mobile,
                    'street' => ($req->street == '' || $req->street == null)? 'N/A' : $req->street,
                    'state' => ($req->state == '' || $req->state == null)? 'N/A' : $req->state,
                    'city' => ($req->city == '' || $req->city == null)? 'N/A' : $req->city,
                    'zip' => ($req->zip == '' || $req->zip == null)? 'N/A' : $req->zip,
                    'position' => $req->position,
                    'sss' => ($req->sss == '' || $req->sss == null)? 'N/A' : $req->sss,
                    'tin' => ($req->tin == '' || $req->tin == null)? 'N/A' : $req->tin,
                    'philhealth' => ($req->philhealth == '' || $req->philhealth == null)? 'N/A' : $req->philhealth,
                    'pagibig' => ($req->pagibig == '' || $req->pagibig == null)? 'N/A' : $req->pagibig,
                    'update_user' => Auth::user()->id,
                    'updated_at' => date('Y-m-d h:i:s')
                ]);

                UserAccess::where('user_id',$req->id)->delete();
                $this->give_acccess($req,$req->id);
        
            }

            if (isset($req->photo)) {
                $this->_global->uploadPhoto($req->id,$req->photo,'employees');
            }

            $data = [
                'msg' => 'Successfully saved.',
                'status' => 'success',
                'employee' => $this->employee($req->id)
            ];
            
        } else {
            $this->validate($req,[
                'firstname' => 'required|string|max:25',
                'lastname' => 'required|string|max:25',
                'email' => 'required|unique:users|email|string',
                'gender' => 'required|string',
                'date_of_birth' => 'required',
                'position' => 'required',
                'password' => 'required|min:5|max:16|confirmed'
            ]);

            $user = new User;

            $user->firstname = $req->firstname;
            $user->lastname = $req->lastname;
            $user->email = $req->email;
            $user->password = Hash::make($req->password);
            $user->actual_password = $req->password;
            $user->gender = $req->gender;

            if (isset($req->disable)) {
                $user->disable = $req->disable;
            }

            if ($user->save()) {
                $this->_global->uploadPhoto($user->id,$req->photo,'employees');

                Employee::create([
                    'user_id' => $user->id,
                    'employee_id' => $this->_global->TransactionNo('EMP_ID'),
                    'date_of_birth' => $req->date_of_birth,
                    'phone' => ($req->phone == '' || $req->phone == null)? 'N/A' : $req->phone,
                    'mobile' => ($req->mobile == '' || $req->mobile == null)? 'N/A' : $req->mobile,
                    'street' => ($req->street == '' || $req->street == null)? 'N/A' : $req->street,
                    'state' => ($req->state == '' || $req->state == null)? 'N/A' : $req->state,
                    'city' => ($req->city == '' || $req->city == null)? 'N/A' : $req->city,
                    'zip' => ($req->zip == '' || $req->zip == null)? 'N/A' : $req->zip,
                    'position' => $req->position,
                    'sss' => ($req->sss == '' || $req->sss == null)? 'N/A' : $req->sss,
                    'tin' => ($req->tin == '' || $req->tin == null)? 'N/A' : $req->tin,
                    'philhealth' => ($req->philhealth == '' || $req->philhealth == null)? 'N/A' : $req->philhealth,
                    'pagibig' => ($req->pagibig == '' || $req->pagibig == null)? 'N/A' : $req->pagibig,
                    'date_hired' => date('Y-m-d h:i:s'),
                    'create_user' => Auth::user()->id,
                    'update_user' => Auth::user()->id
                ]);

                $this->give_access($req,$user->id);
            }

            $data = [
                'msg' => 'Successfully saved.',
                'status' => 'success',
                'employee' => $this->employee($user->id)
            ];
        }

        return response()->json($data);
    }

    private function give_acccess($req,$id)
    {
        $accesses = [];

        if (isset($req->rw)) {
            foreach ($req->rw as $key => $rw) {
                array_push($accesses, [
                    'module_id' => $rw,
                    'user_id' => $id,
                    'access' => 1,
                    'create_user' => Auth::user()->id,
                    'update_user' => Auth::user()->id
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
                        'update_user' => Auth::user()->id
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
            ]);
        }

        array_unique($user_accesses,SORT_REGULAR);

        $allowAccess = array_chunk($user_accesses, 1000);

        foreach ($allowAccess as $access) {
            UserAccess::insert($access);
        }
    }

    public function edit($id)
    {
        return view('pages.employee.registration',[
            'user_access' => $this->_global->UserAccess(),
            'id' => $id
        ]);
    }

    public function show_list()
    {
        $employee = DB::table('users as u')
                        ->join('employees as e','u.id','=','e.user_id')
                        ->select(
                            DB::raw('u.id as id'),
                            DB::raw('u.photo as photo'),
                            DB::raw('u.firstname as firstname'),
                            DB::raw('u.lastname as lastname'),
                            DB::raw('u.email as email'),
                            DB::raw('u.gender as gender'),
                            DB::raw('e.date_of_birth as date_of_birth'),
                            DB::raw('e.phone as phone'),
                            DB::raw('e.mobile as mobile'),
                            DB::raw('e.street as street'),
                            DB::raw('e.state as state'),
                            DB::raw('e.city as city'),
                            DB::raw('e.zip as zip'),
                            DB::raw('e.position as position'),
                            DB::raw('e.sss as sss'),
                            DB::raw('e.tin as tin'),
                            DB::raw('e.philhealth as philhealth'),
                            DB::raw('e.pagibig as pagibig'),
                            DB::raw('e.date_hired as date_hired'),
                            DB::raw('e.employee_id as employee_id')
                        )->get();

        return response()->json($employee);
    }

    public function show(Request $req)
    {
        return response()->json($this->employee($req->id));
    }

    public function employee($id)
    {
        $employee = DB::table('users as u')
                        ->join('employees as e','u.id','=','e.user_id')
                        ->where('u.id',$id)
                        ->select(
                            DB::raw('u.id as id'),
                            DB::raw('u.photo as photo'),
                            DB::raw('u.firstname as firstname'),
                            DB::raw('u.lastname as lastname'),
                            DB::raw('u.email as email'),
                            DB::raw('u.gender as gender'),
                            DB::raw('e.date_of_birth as date_of_birth'),
                            DB::raw('e.phone as phone'),
                            DB::raw('e.mobile as mobile'),
                            DB::raw('e.street as street'),
                            DB::raw('e.state as state'),
                            DB::raw('e.city as city'),
                            DB::raw('e.zip as zip'),
                            DB::raw('e.position as position'),
                            DB::raw('e.sss as sss'),
                            DB::raw('e.tin as tin'),
                            DB::raw('e.philhealth as philhealth'),
                            DB::raw('e.pagibig as pagibig'),
                            DB::raw('e.date_hired as date_hired'),
                            DB::raw('e.employee_id as employee_id')
                        )
                        ->first();
        return $employee;
    }

    public function destroy($id)
    {
        $data = [
            'msg' => 'Deleting failed.',
            'status' => 'failed',
            'employee' => ''
        ];

        if (isset($id)) {
            $employee = Employee::find($id);
            if ($employee->delete()) {
                $data = [
                    'msg' => 'Successfully deleted.',
                    'status' => 'success',
                    'employee' => $this->employee($id)
                ];
            }
        }

        return response()->json($data);
    }
}
