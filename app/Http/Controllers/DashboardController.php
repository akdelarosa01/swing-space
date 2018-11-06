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
                return view('pages.dashboard.owner',[
                    'user_access' => $this->_global->UserAccess()
                ]);
                break;

            case 'Employee':
                return view('pages.dashboard.employee',[
                    'user_access' => $this->_global->UserAccess()
                ]);
                break;

            case 'Customer':
                return view('pages.dashboard.customer',[
                    'user_access' => $this->_global->UserAccess()
                ]);
                break;
            
            default:
                return view('super_admin.dashboard',[
                    'user_access' => $this->_global->UserAccess()
                ]);
                break;
        }
    }
}
