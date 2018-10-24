<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Customer;
use App\User;

class CustomerController extends Controller
{
    protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }

    public function index()
    {
        return view('pages.customer.customer_list');
    }

    public function save(Request $req)
    {
        //
    }

    public function show()
    {
        $users = new User;
        return $users->customer;
    }

    public function destroy(Request $req)
    {
        //
    }
}
