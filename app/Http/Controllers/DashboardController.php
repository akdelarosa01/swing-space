<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\SuperAdmin\UserLogsController;
use App\CurrentCustomer;
use App\Customer;
use App\CustomerProductBill;
use App\Employee;
use App\Product;
use Carbon\Carbon;
use Excel;
use DB;

class DashboardController extends Controller
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

    public function DailySalesFromRegisteredCustomer()
    {
        $sales = DB::select("SELECT ifnull(u.id,0) as id,
                                    ifnull(c.customer_code,'N/A') as code,
                                    s.firstname as firstname,
                                    s.lastname as lastname,
                                    ifnull(c.points,'N/A') as points,
                                    ifnull(u.photo,'/img/default-profile.png') as photo,
                                    concat('₱', format(sum(total_sale), 2)) as total_sale
                            from sales as s
                            left join customers as c
                            on s.customer_code = c.customer_code
                            left join users as u
                            on c.user_id = u.id
                            where left(s.created_at,10) like '".date('Y-m-d')."'
                            group by u.id,
                                    c.customer_code,
                                    s.firstname,
                                    s.lastname,
                                    c.points,
                                    u.photo
                            order by sum(s.total_sale) desc");
        return response()->json($sales);
    }

    public function DailySoldProductsPerMonth()
    {
        $sales = DB::select("SELECT prod_code,
                                prod_name,
                                SUM(quantity) as quantity,
                                concat('₱', format(sum(cost), 2)) as amount
                            FROM customer_product_bills
                            where left(created_at,10) like '".date('Y-m-d')."'
                            group by prod_code,
                                    prod_name
                            order by sum(cost) desc");
        return response()->json($sales);
    }

    public function SalesFromRegisteredCustomer()
    {
        $sales = DB::select("SELECT ifnull(u.id,0) as id,
                                    ifnull(c.customer_code,'N/A') as code,
                                    s.firstname as firstname,
                                    s.lastname as lastname,
                                    ifnull(c.points,'N/A') as points,
                                    ifnull(u.photo,'/img/default-profile.png') as photo,
                                    concat('₱', format(sum(total_sale), 2)) as total_sale
                            from sales as s
                            left join customers as c
                            on s.customer_code = c.customer_code
                            left join users as u
                            on c.user_id = u.id
                            where left(s.created_at,10) like '".date('Y-m')."%'
                            group by u.id,
                                    c.customer_code,
                                    s.firstname,
                                    s.lastname,
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
                            FROM customer_product_bills
                            where left(created_at,10) like '".date('Y-m')."%'
                            group by prod_code,
                                    prod_name
                            order by sum(cost) desc");
        return response()->json($sales);
    }

    public function customerBill()
    {
        $cust = DB::table('customers')->select('customer_code')->where('user_id',Auth::user()->id)->first();

        $bills = DB::select("SELECT b.prod_code as prod_code,
                                b.prod_name as prod_name,
                                b.quantity as quantity,
                                b.price as price
                            from current_customers as c
                            inner join current_customer_bills as b
                            on b.current_cust_id = c.id
                            where b.created_at like '".date('Y-m-d')."%'
                            and c.cust_code = '".$cust->customer_code."'");
        
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

    public function ReportForThisMonth()
    {
        $date = date('Ymd');

        $this->_userlog->log([
            'module' => 'Month Report',
            'action' => 'Donwloaded a Month Report file dated '.date('Y-m-d'),
            'user_id' => Auth::user()->id
        ]);

        Excel::create('Month_Report_'.$date, function($excel)
        {
            $excel->sheet('Sales Per Customer', function($sheet)
            {
                $sheet->setHeight(1, 15);
                $sheet->mergeCells('A1:F1');
                $sheet->cells('A1:F1', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true,
                    ]);
                });
                $sheet->cell('A1'," SWING SPACE");

                $sheet->setHeight(2, 15);
                $sheet->mergeCells('A2:F2');
                $sheet->cells('A2:F2', function($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->setHeight(4, 20);
                $sheet->mergeCells('A4:F4');
                $sheet->cells('A4:F4', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true,
                        'underline'  =>  true
                    ]);
                });
                $sheet->cell('A4',"Sales Per Customer");

                $sheet->cells('A6:F6', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '12',
                        'bold'       =>  true
                    ]);
                });

                $sheet->cell('B6',"Cust. Code");
                $sheet->cell('C6',"First Name");
                $sheet->cell('D6',"Last Name");
                $sheet->cell('E6',"Points");
                $sheet->cell('F6',"Total Sale");


                $sales = DB::select("SELECT 
                                    concat('₱', format(sum(total_sale), 2)) as total_sale,
                                    date_format(s.created_at,'%b %d, %Y') as dates
                            from sales as s
                            left join customers as c
                            on s.customer_code = c.customer_code
                            left join users as u
                            on c.user_id = u.id
                            where left(s.created_at,10) like '".date('Y-m')."%'
                            group by date_format(s.created_at,'%b %d, %Y')
                            order by left(s.created_at,10) desc");

                $row = 7;
                foreach ($sales as $key => $sale) {
                    $sheet->cell('A'.$row, function($cell) use($sale) {
                        $cell->setAlignment('center');
                        $cell->setFont([
                            'family'     => 'Calibri',
                            'size'       => '12',
                            'bold'       =>  true,
                        ]);
                        $cell->setValue($sale->dates);
                    });

                    //$sheet->cell('A'.$row, $sale->dates);
                    $cust = DB::select("SELECT ifnull(u.id,0) as id,
                                                ifnull(c.customer_code,'N/A') as code,
                                                s.firstname as firstname,
                                                s.lastname as lastname,
                                                ifnull(c.points,'N/A') as points,
                                                ifnull(u.photo,'/img/default-profile.png') as photo,
                                                concat('₱', format(sum(total_sale), 2)) as total_sale,
                                                date_format(s.created_at,'%b %d, %Y') as dates
                                        from sales as s
                                        left join customers as c
                                        on s.customer_code = c.customer_code
                                        left join users as u
                                        on c.user_id = u.id
                                        where left(s.created_at,10) like '".date('Y-m')."%'
                                        and date_format(s.created_at,'%b %d, %Y') = '".$sale->dates."'
                                        group by u.id,
                                                c.customer_code,
                                                s.firstname,
                                                s.lastname,
                                                c.points,
                                                u.photo,
                                                date_format(s.created_at,'%b %d, %Y')
                                        order by s.lastname desc");
                    $row++;
                    foreach ($cust as $key => $c) {
                        $sheet->cell('B'.$row, $c->code);
                        $sheet->cell('C'.$row, $c->firstname);
                        $sheet->cell('D'.$row, $c->lastname);
                        $sheet->cell('E'.$row, $c->points);
                        $sheet->cell('F'.$row, $c->total_sale);
                        $row++;
                    }
                }
                
                // $sheet->cells('A6:C'.$row, function($cells) {
                //     $cells->setBorder('solid', 'solid', 'solid', 'solid');
                // });
            });

            $excel->sheet('Sales Per Product', function($sheet)
            {
                $sheet->setHeight(1, 15);
                $sheet->mergeCells('A1:H1');
                $sheet->cells('A1:H1', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true,
                    ]);
                });
                $sheet->cell('A1'," SWING SPACE");

                $sheet->setHeight(2, 15);
                $sheet->mergeCells('A2:H2');
                $sheet->cells('A2:H2', function($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->setHeight(4, 20);
                $sheet->mergeCells('A4:H4');
                $sheet->cells('A4:H4', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true,
                        'underline'  =>  true
                    ]);
                });
                $sheet->cell('A4',"Sales Per Product");


                $salesp = DB::select("SELECT 
                                    concat('₱', format(sum(cost), 2)) as amount,
                                    date_format(created_at,'%b %d, %Y') as dates
                            FROM customer_product_bills
                            where left(created_at,10) like '".date('Y-m')."%'
                            group by date_format(created_at,'%b %d, %Y')
                            order by left(created_at,10) desc");

                $sheet->cells('A6:H6', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '12',
                        'bold'       =>  true
                    ]);
                });

                $sheet->cell('B6',"Prod. Code");
                $sheet->cell('C6',"Prod. Name");
                $sheet->cell('D6',"Quantity");
                $sheet->cell('E6',"Sales Per Product");

                $sheet->cell('F6',"Cust. Code");
                $sheet->cell('G6',"First Name");
                $sheet->cell('H6',"Last Name");

                $row = 7;
                foreach ($salesp as $key => $psale) {
                    $sheet->cell('A'.$row, function($cell) use($psale) {
                        $cell->setAlignment('center');
                        $cell->setFont([
                            'family'     => 'Calibri',
                            'size'       => '12',
                            'bold'       =>  true,
                        ]);
                        $cell->setValue($psale->dates);
                    });
                    $sheet->setHeight($row, 15);

                    $prod = DB::select("SELECT prod_code as prod_code,
                                            prod_name as prod_name,
                                            ifnull(customer_code,'N/A') as customer_code,
                                            firstname as firstname,
                                            lastname as lastname,
                                            SUM(quantity) as quantity,
                                            concat('₱', format(sum(cost), 2)) as amount FROM customer_product_bills
                                        where left(created_at,10) like '".date('Y-m')."%'
                                        and date_format(created_at,'%b %d, %Y') = '".$psale->dates."'
                                        group by prod_code,
                                                prod_name,
                                                customer_code,
                                                firstname,
                                                lastname
                                        order by lastname desc");
                    $row++;
                    foreach ($prod as $key => $p) {
                        $sheet->cell('B'.$row, $p->prod_code);
                        $sheet->cell('C'.$row, $p->prod_name);
                        $sheet->cell('D'.$row, $p->quantity);
                        $sheet->cell('E'.$row, $p->amount);

                        $sheet->cell('F'.$row, $p->customer_code);
                        $sheet->cell('G'.$row, $p->firstname);
                        $sheet->cell('H'.$row, $p->lastname);
                        $row++;
                    }
                }
                
                // $sheet->cells('A6:C'.$row, function($cells) {
                //     $cells->setBorder('solid', 'solid', 'solid', 'solid');
                // });
            });
        })->download('xlsx');
    }
}
