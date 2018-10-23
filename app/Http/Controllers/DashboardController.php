<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;

class DashboardController extends Controller
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
                return view('pages.dashboard_owner');
                break;

            case 'Employee':
                return view('pages.dashboard_employee');
                break;

            case 'Customer':
                return view('pages.dashboard_customer');
                break;
            
            default:
                return view('super_admin.dashboard');
                break;
        }
    }
}
