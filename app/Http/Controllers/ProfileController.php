<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Employee;
use App\Customer;

class ProfileController extends Controller
{
    protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }
    
    public function index()
    {
        switch (Auth::user()->user_type) {
            case 'Owner':
                return view('pages.profile.owner',[
                    'user_access' => $this->_global->UserAccess()
                ]);
                break;

            case 'Employee':
                $emp = $this->employee(Auth::user()->id);
                return view('pages.profile.employee',[
                    'user_access' => $this->_global->UserAccess(),
                    'emp' => $emp
                ]);
                break;

            case 'Customer':
                $cust = $this->customer(Auth::user()->id);
                return view('pages.profile.customer',[
                    'user_access' => $this->_global->UserAccess(),
                    'cust' => $cust
                ]);
                break;
            
            default:
                return view('super_admin.profile',[
                    'user_access' => $this->_global->UserAccess()
                ]);
                break;
        }
    }

    public function employee($id)
    {
        $emp = Employee::where('user_id',$id)->first();
        return $emp;
    }

    public function customer($id)
    {
        $cust = Customer::where('user_id',$id)->first();
        return $cust;
    }
}
