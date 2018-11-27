<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\UserLogsController;
use Carbon\Carbon;
use App\Events\POS;
use App\Product;
use App\DropdownOption;
use App\CurrentCustomer;
use App\CurrentCustomerBill;
use App\CustomerProductBill;
use App\Reward;
use App\Incentive;
use App\Discount;
use App\CustomerLog;
use App\Customer;
use App\CustomerPoint;
use App\Sale;
use DB;
use PDF;


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
            'cust_timein' => (isset($req->cust_timein))? $this->_global->convertDate($req->cust_timein,'Y-m-d H:i:s') : date('Y-m-d H:i:s'),
            'create_user' => Auth::user()->id,
            'update_user' => Auth::user()->id,
        ]);

        $cus = Customer::where('customer_code',$code)
                        ->select('user_id')->first();

        CustomerLog::create([
            'customer_id' => (isset($cus->user_id))? $cus->user_id : 0,
            'date_logged' => date('Y-m-d'),
            'time_in' => date('Y-m-d H:i:s'),
            'time_out' => date('Y-m-d H:i:s'),
            'hrs' => 0
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

    public function calculate_rewards(Request $req)
    {
        $rwd = Reward::select('deducted_price','deducted_points')->first();
        $computed_points = 0;
        $price_to_deduct = 0;
        $points = intval($req->points);

        if ($points >= $rwd->deducted_points) {
            $computed_points = $points / $rwd->deducted_points;
        }

        if ($points <= $rwd->deducted_points) {
            $computed_points = $rwd->deducted_points / $points;
        }

        $price_to_deduct = $computed_points * $rwd->deducted_price;

        $data = [
            'points_to_deduct' => $points,
            'price_to_deduct' => $price_to_deduct
        ];
        
        return response()->json($data);
    }

    public function save_payments(Request $req)
    {
        $data = [
            'msg' => 'Payment Failed.',
            'status' => 'failed'
        ];

        $currcust = CurrentCustomer::where('id',$req->cust_id)->first();

        $saved = $this->saveSoldProducts($currcust->cust_code,$req);

        $this->deductRewardPoints($currcust->cust_code,$req->reward_points);

        $this->giveIncentives($currcust->cust_code,$req->order_total_amount);

        if ($req->email_receipt > 0) {
            $this->EmailCustomerReceipt($req);
        }

        if ($saved) {
            CurrentCustomer::where('id',$req->cust_id)->delete();
            $data = [
                'msg' => 'Payment successfully transacted',
                'status' => 'success'
            ];
        }

        $bill = CurrentCustomerBill::where('cust_id',$req->cust_id)->get();
        event(new POS($bill));

        return $data;
    }

    public function EmailCustomerReceipt($req)
    {
        # code...
    }

    public function giveIncentives($cust_code,$order_total_amount)
    {
        $customer = Customer::where('customer_code',$cust_code)
                        ->select('user_id','referrer')->first();

        $inc = DB::select("select points from incentives
                    where ".$order_total_amount." between price_from and price_to");

        if (count((array)$inc) > 0) {
            if (count((array)$customer) > 0) {
                $cust = User::select(DB::raw("concat(firstname,' ',lastname) as buyer_name"))
                            ->where('id',$customer->user_id)->first();

                CustomerPoint::create([
                    'customer_id' => $customer->referrer,
                    'remarks' => $inc[0]->points.' points accumulated from your referred customer '.$cust->buyer_name,
                    'accumulated_points' => $inc[0]->points
                ]);

                if ($customer->referrer > 0) {
                    Customer::where('user_id',$customer->referrer)->increment(
                                'points', $inc[0]->points,[
                                    'update_user' => Auth::user()->id,
                                    'updated_at' => date('Y-m-d h:i:s')
                                ]
                            );
                }
            }
        }
    }

    public function saveSoldProducts($cust_code,$req)
    {
        $cust = Customer::where('customer_code',$cust_code)
                        ->select('user_id')->first();
        $sub_total = 0;
        $discount = $req->discount_value + $req->reward_price;

        foreach ($req->order_prod_id as $key => $prod_id) {
            $prod = Product::where('id',$prod_id)->first();

            if (count((array)$cust) > 0) {
                CustomerProductBill::create([
                    'customer_id' => $cust->user_id,
                    'prod_code' => $prod->prod_code,
                    'prod_name' => $prod->prod_name,
                    'prod_type' => $prod->prod_type,
                    'variants' => $prod->variants,
                    'quantity' => $req->order_quantity[$key],
                    'cost' => $req->order_price[$key]
                ]);
            } else {
                CustomerProductBill::create([
                    'customer_id' => 0, //walk ins
                    'prod_code' => $prod->prod_code,
                    'prod_name' => $prod->prod_name,
                    'prod_type' => $prod->prod_type,
                    'variants' => $prod->variants,
                    'quantity' => $req->order_quantity[$key],
                    'cost' => $req->order_price[$key]
                ]);
            }

            

            $sub_total += $req->order_price[$key];
        }

        $sales;

        if (count((array)$cust) > 0) {
            $sales = Sale::create([
                        'customer_code' => $cust_code,
                        'sub_total' => $sub_total,
                        'discount' => $discount,
                        'payment' => $req->order_payment,
                        'change' => $req->order_change,
                        'total_sale' => $req->order_total_amount,
                        'create_user' => Auth::user()->id,
                        'update_user' => Auth::user()->id
                    ]);
        } else {
            $sales = Sale::create([
                        'customer_code' => 'N/A',
                        'sub_total' => $sub_total,
                        'discount' => $discount,
                        'payment' => $req->order_payment,
                        'change' => $req->order_change,
                        'total_sale' => $req->order_total_amount,
                        'create_user' => Auth::user()->id,
                        'update_user' => Auth::user()->id
                    ]);
        }

        
        if ($sales) {
            return true;
        }
    }

    public function deductRewardPoints($cust_code,$points)
    {
        if (isset($points)) {
            Customer::where('customer_code',$cust_code)->decrement(
                        'points', $points,[
                            'update_user' => Auth::user()->id,
                            'updated_at' => date('Y-m-d h:i:s')
                        ]
                    );
        }
    }
}
