<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\CurrentCustomer;
use App\Customer;
use App\CustomerProductBill;
use App\Employee;
use App\Product;
use Carbon\Carbon;
use DB;

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

    public function customersToday()
    {
        $custs = DB::table('current_customers as c')->select(
                        DB::raw("c.id as id"),
                        DB::raw("c.cust_code as code"),
                        DB::raw("c.cust_firstname as firstname"),
                        DB::raw("c.cust_lastname as lastname"),
                        DB::raw("ifnull(SUM(b.price),0) as total_bill"),
                        DB::raw("ifnull(u.photo,'/img/default-profile.png') as photo"),
                        DB::raw("ifnull(cus.points,0) as points")
                    )
                    ->leftJoin('current_customer_bills as b','c.id','=','b.current_cust_id')
                    ->leftJoin('customers as cus','c.cust_code','=','cus.customer_code')
                    ->leftJoin('users as u','cus.user_id','=','u.id')
                    ->groupBy('c.id',
                            'c.cust_code',
                            'c.cust_firstname',
                            'c.cust_lastname',
                            'u.photo',
                            'cus.points'
                        )->get();
        return response()->json($custs);
    }

    public function EmployeeTotalStatistic()
    {
        $total_customers = Customer::count();
        $total_sold_product = CustomerProductBill::where('created_at','like',date('Y-m-d').'%')
                                ->select(
                                    DB::raw("sum(quantity) as quantity")
                                )->first();
        $total_earnings = CustomerProductBill::where('created_at','like',date('Y-m-d').'%')
                                ->select(
                                    DB::raw("concat('₱', format(sum(cost), 2)) as cost")
                                )->first();

        $data = [
            'total_customers' => $total_customers,
            'total_sold_product' => $total_sold_product->quantity,
            'total_earnings' => $total_earnings->cost
        ];
        return response()->json($data);
    }

    public function getSales()
    {
        $date = Carbon::now();
        $date->setISODate(date('Y'),date('W'));
        $start = $this->_global->convertDate($date->startOfMonth(),'Y-m-d');
        $end = $this->_global->convertDate($date->endOfMonth(),'Y-m-d');

        $labels = [];
        $series = [];
        $sales = DB::select("SELECT 
                                sum(total_sale) as total_sale,
                                left(created_at,10) as date_today
                            FROM sales
                            where left(created_at,10) like '".date('Y-m')."%'
                            group by left(created_at,10)
                            order by left(created_at,10)");

        foreach ($sales as $key => $s) {
            array_push($labels, $this->_global->convertDate($s->date_today,'m/d/Y'));
            array_push($series, $s->total_sale);
        }

        $total_weekly_sale = 0;

        foreach ($series as $key => $amount) {
            $total_weekly_sale += $amount;
        }

        $data = [
            'labels' => $labels,
            'series' => $series,
            'monthly_sale' => '₱'.number_format($total_weekly_sale,2),
            'start_date' => $this->_global->convertDate($date->startOfMonth(),'M d, Y'),
            'end_date' => $this->_global->convertDate($date->endOfMonth(),'M d, Y'),
        ];

        return response()->json($data);
    }

    public function OwnerTotalStatistic()
    {
        $total_customers = Customer::count();
        $total_employees = Employee::count();
        $total_products = Product::count();

        $data = [
            'total_customers' => $total_customers,
            'total_employees' => $total_employees,
            'total_products' => $total_products
        ];
        return response()->json($data);
    }

    public function SalesFromRegisteredCustomer()
    {
        $sales = DB::select("SELECT u.id as id,
                                    c.customer_code as code,
                                    u.firstname as firstname,
                                    u.lastname as lastname,
                                    c.points as points,
                                    u.photo as photo,
                                    concat('₱', format(sum(total_sale), 2)) as total_sale
                            from sales as s
                            inner join customers as c
                            on s.customer_code = c.customer_code
                            inner join users as u
                            on c.user_id = u.id
                            where left(s.created_at,10) like '".date('Y-m')."%'
                            group by u.id,
                                    c.customer_code,
                                    u.firstname,
                                    u.lastname,
                                    c.points,
                                    u.photo
                            order by sum(s.total_sale) desc");
        return response()->json($sales);
    }

    public function SoldProductsPerMonth()
    {
        $sales = DB::select("SELECT prod_code,
                                prod_name,
                                SUM(quantity) as quantity,
                                concat('₱', format(sum(cost), 2)) as amount
                            FROM swingspace.customer_product_bills
                            where left(created_at,10) like '".date('Y-m')."%'
                            group by prod_code,
                                    prod_name
                            order by sum(cost) desc");
        return response()->json($sales);
    }

    public function customerBill()
    {
        $bills = DB::select("SELECT b.prod_code as prod_code,
                                b.prod_name as prod_name,
                                b.quantity as quantity,
                                b.price as price
                            from current_customers as c
                            inner join current_customer_bills as b
                            on b.current_cust_id = c.id
                            where b.created_at like '".date('Y-m-d')."%'");
        return response()->json($bills);
    }

    public function CustomerStatistic()
    {
        $cust = Customer::select('customer_code','points')
                        ->where('user_id',Auth::user()->id)
                        ->first();

        $data = [
            'available_points' => $cust->points,
            'customer_code' => $cust->customer_code
        ];
        return response()->json($data);
    }

    public function referredCustomers()
    {
        $cust = DB::select("SELECT u.id as id,
                                u.photo as photo,
                                c.customer_code as code,
                                u.firstname as firstname,
                                u.lastname as lastname
                            FROM users as u
                            inner join customers as c
                            on c.user_id = u.id
                            where referrer = ".Auth::user()->id);

        return response()->json($cust);
    }
}
