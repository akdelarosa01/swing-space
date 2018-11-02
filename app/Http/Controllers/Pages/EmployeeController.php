<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Employee;
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

            $this->_global->uploadPhoto($req->id,$req->photo,'employees');

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
                'position' => 'required'
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
                $this->_global->uploadPhoto($user->id,$req->photo,'employees');

                Employee::create([
                    'user_id' => $user->id,
                    'employee_id' => 'A00001',
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
            }

            $data = [
                'msg' => 'Successfully saved.',
                'status' => 'success',
                'employee' => $this->employee($user->id)
            ];
        }

        return response()->json($data);
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
                            DB::raw('e.date_hired as date_hired')
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
                            DB::raw('e.date_hired as date_hired')
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
