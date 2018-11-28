<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Employee;
use App\Customer;
use App\CustomerProductBill;
use DB;

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

    public function purchaseHistory()
    {
        $bills = DB::select("SELECT prod_code,
                                    prod_name,
                                    variants,
                                    quantity,
                                    concat('₱', format(cost, 2)) as cost,
                                    DATE_FORMAT(created_at,'%b %d, %Y') as created_at
                            FROM customer_product_bills
                            order by id desc");
        
        return response()->json($bills);
    }

    public function getQRcode()
    {
        $cust = Customer::select('customer_code')->where('user_id',Auth::user()->id)->first();
        return response()->json($cust);
    }

    public function getQRcodeEmployee()
    {
        $emp = Employee::select('employee_id')->where('user_id',Auth::user()->id)->first();
        return response()->json($emp);
    }
}
