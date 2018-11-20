<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\UserLogsController;
use App\Events\POS;
use App\Product;
use App\DropdownOption;
use App\CurrentCustomer;
use App\CurrentCustomerBill;
use App\Reward;
use App\Discount;
use DB;


class POSControlController extends Controller
{
    protected $_global;
    protected $_userlog;

    public function __construct()
    {
        $this->_global = new GlobalController;
        $this->_userlog = new UserLogsController;
    }

    public function index()
    {
        if ($this->_global->checkAccess('POS_CTRL')) {
            return view('pages.pos.pos',[
                'user_access' => $this->_global->UserAccess()
            ]);
        } else {
            return redirect('/dashboard');
        }
    }

    public function show_products(Request $req)
    {
        $prods = $this->products($req->product_type);
        return response()->json($prods);
    }

    private function products($type = '')
    {
        if ($type == '') {
            $products = DB::select("SELECT p.id as id,
                                        p.prod_code as prod_code,
                                        p.prod_name as prod_name,
                                        p.prod_type as prod_type,
                                        p.price as price,
                                        p.variants as variants,
                                        p.description as `description`,
                                        CASE
                                            when (SELECT a.target_qty
                                                    FROM available_products as a
                                                    where a.prod_id = p.id limit 1) is not null
                                            then (SELECT a.target_qty
                                                    FROM available_products as a
                                                    where a.prod_id = p.id limit 1)
                                            else 0
                                        END  as target_qty,
                                        CASE
                                            when (SELECT a.quantity
                                                    FROM available_products as a
                                                    where a.prod_id = p.id limit 1) is not null
                                            then (SELECT a.quantity
                                                    FROM available_products as a
                                                    where a.prod_id = p.id limit 1)
                                            else 0
                                        END  as quantity,
                                        CASE
                                            when (SELECT DATE_FORMAT(a.updated_at, '%Y/%m/%d %H:%i %p') as updated_at
                                                    FROM available_products as a
                                                    where a.prod_id = p.id limit 1) is not null
                                            then (SELECT DATE_FORMAT(a.updated_at, '%Y/%m/%d %H:%i %p') as updated_at
                                                    FROM available_products as a
                                                    where a.prod_id = p.id limit 1)
                                            else 0
                                        END  as updated_at
                                from products as p
                                order by updated_at desc");
        } else {
            $products = DB::select("SELECT p.id as id,
                                        p.prod_code as prod_code,
                                        p.prod_name as prod_name,
                                        p.prod_type as prod_type,
                                        p.price as price,
                                        p.variants as variants,
                                        p.description as `description`,
                                        CASE
                                            when (SELECT a.target_qty
                                                    FROM available_products as a
                                                    where a.prod_id = p.id limit 1) is not null
                                            then (SELECT a.target_qty
                                                    FROM available_products as a
                                                    where a.prod_id = p.id limit 1)
                                            else 0
                                        END  as target_qty,
                                        CASE
                                            when (SELECT a.quantity
                                                    FROM available_products as a
                                                    where a.prod_id = p.id limit 1) is not null
                                            then (SELECT a.quantity
                                                    FROM available_products as a
                                                    where a.prod_id = p.id limit 1)
                                            else 0
                                        END  as quantity,
                                        CASE
                                            when (SELECT DATE_FORMAT(a.updated_at, '%Y/%m/%d %H:%i %p') as updated_at
                                                    FROM available_products as a
                                                    where a.prod_id = p.id limit 1) is not null
                                            then (SELECT DATE_FORMAT(a.updated_at, '%Y/%m/%d %H:%i %p') as updated_at
                                                    FROM available_products as a
                                                    where a.prod_id = p.id limit 1)
                                            else 0
                                        END  as updated_at
                                from products as p
                                where prod_type = '".$type."'
                                order by updated_at desc");
        }
        
        return $products;
    }

    public function product_types()
    {
        $types = DropdownOption::where('dropdown_id',3)->get();
        return response()->json($types);
    }

    public function check_in_member(Request $req)
    {
        $cust;
        if (isset($req->cust_code)) {
            $cust = DB::table('users as u')
                        ->join('customers as c','u.id','=','c.user_id')
                        ->where('u.disabled',0)
                        ->where('c.customer_code',$req->cust_code)
                        ->orderBy('u.id')
                        ->select(
                            DB::raw('u.id as id'),
                            DB::raw('u.firstname as cust_firstname'),
                            DB::raw('u.lastname as cust_lastname'),
                            DB::raw('c.customer_code as cust_code')
                        )
                        ->get();
        } else {
            $cust = DB::table('users as u')
                        ->join('customers as c','u.id','=','c.user_id')
                        ->where('u.disabled',0)
                        ->orderBy('u.id')
                        ->select(
                            DB::raw('u.id as id'),
                            DB::raw('u.firstname as cust_firstname'),
                            DB::raw('u.lastname as cust_lastname'),
                            DB::raw('c.customer_code as cust_code')
                        )
                        ->get();
        }

        return response()->json($cust);
    }

    public function save_currentCustomer(Request $req)
    {
        $data = [
            'msg' => 'Check In failed.',
            'status' => 'failed'
        ];

        $code = $req->cust_code;

        if ($req->type == 'walkin') {
            $code = 'N/A';

            $this->validate($req,[
                'cust_firstname' => 'required',
                'cust_lastname' => 'required',
                'cust_timein' => 'required'
            ]);
        }

        $cust = CurrentCustomer::create([
            'cust_code' => $code,
            'cust_firstname' => $req->cust_firstname,
            'cust_lastname' => $req->cust_lastname,
            'cust_timein' => (isset($req->cust_timein))? $req->cust_timein : date('H:i:s'),
            'create_user' => Auth::user()->id,
            'update_user' => Auth::user()->id,
        ]);

        if ($cust) {
            $data = [
                'msg' => 'Customer successfully checked in.',
                'status' => 'success'
            ];
        }

        return response()->json($data);
    }

    public function show_currentCustomer()
    {
        $cust = DB::table('current_customers as cc')
                    ->leftJoin('customers as c','cc.cust_code','=','c.customer_code')
                    ->select(
                        DB::raw('cc.id as id'),
                        DB::raw('cc.cust_code as cust_code'),
                        DB::raw('cc.cust_firstname as cust_firstname'),
                        DB::raw('cc.cust_lastname as cust_lastname'),
                        DB::raw('cc.cust_timein as cust_timein'),
                        DB::raw('IFNULL(c.points,0) as points')
                    )->get();
        return response()->json($cust);
    }

    public function save_currentBill(Request $req)
    {
        $check = CurrentCustomerBill::where([
                    ['cust_id',$req->cust_id],
                    ['prod_id',$req->prod_id]
                ])->count();
        if ($check < 1) {
            CurrentCustomerBill::create([
                'cust_id' => $req->cust_id,
                'prod_id' => $req->prod_id,
                'prod_code' => $req->prod_code,
                'prod_name' => $req->prod_name,
                'quantity' => 1,
                'price' => $req->price,
                'unit_price' => $req->unit_price,
                'create_user' => Auth::user()->id,
                'update_user' => Auth::user()->id
            ]);
        }

        $bill = CurrentCustomerBill::where('cust_id',$req->cust_id)->get();

        event(new POS($bill));

        return response()->json($bill);
    }

    public function show_currentBill(Request $req)
    {
        $bill = CurrentCustomerBill::where('cust_id',$req->cust_id)->get();
        event(new POS($bill));

        return response()->json($bill);
    }

    public function delete_currentItemBill(Request $req)
    {
        $delete = CurrentCustomerBill::where([
            ['cust_id',$req->cust_id],
            ['prod_id',$req->prod_id]
        ])->delete();

        if ($delete) {
            $bill = CurrentCustomerBill::where('cust_id',$req->cust_id)->get();
            event(new POS($bill));

            return response()->json($bill);
        }
    }

    public function update_currentItemBill(Request $req)
    {
        $update = CurrentCustomerBill::where([
            ['cust_id',$req->cust_id],
            ['prod_id',$req->prod_id]
        ])->update([
            'quantity' => $req->quantity,
            'price' => $req->quantity*$req->unit_price
        ]);

        if ($update) {
            $bill = CurrentCustomerBill::where('cust_id',$req->cust_id)->get();
            event(new POS($bill));

            return response()->json($bill);
        }
    }

    public function show_discounts()
    {
        $discounts = Discount::all();
        return response()->json($discounts);
    }

    public function show_rewards()
    {
        $rewards = Rewards::all();
        return response()->json($rewards);
    }
}
