<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\SuperAdmin\UserLogsController;
use Carbon\Carbon;
use Excel;
use DB;

class SalesReportController extends Controller
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
        if ($this->_global->checkAccess('SAL_RPT')) {
            return view('pages.reports.sales_report',[
                'user_access' => $this->_global->UserAccess()
            ]);
        } else {
            return redirect('/dashboard');
        }
    }

    public function sales(Request $req)
    {
        $date_cond = '';
        if ($req->datefrom == '') {
            $date_cond = "";
        } else {
            $datefrom = $this->_global->convertDate($req->datefrom,'Y-m-d');
            $dateto = $this->_global->convertDate($req->dateto,'Y-m-d');

            $date_cond = " AND left(created_at,10) between '".$datefrom."' AND '".$dateto."'";
        }

        $sales = DB::select("select customer_code,
                                    firstname,
                                    lastname,
                                    IF(customer_type = 'M','Member','Walk-In') as customer_type,
                                    concat('₱',format(total_sale,2)) as total_sale,
                                    date_format(created_at,'%b. %d, %Y') as date_purchase,
                                    created_at
                                    from sales where 1=1".$date_cond." 
                                    order by created_at desc");

        // if (count((array)$sales) > 0) {
            return response()->json($sales);
        // }
        
    }

    public function monthlySalesPerProductReport()
    {
        $data = [];
        $date = Carbon::now();
        $year_now = $date->format('Y');

        $prod_type = DB::select("select prod_type
                                from products
                                where prod_type not in('Services','Space Rental')
                                and left(created_at,4) = '".$year_now."'
                                group by prod_type");

        foreach ($prod_type as $key => $type) {
            $details = DB::select("SELECT sum(cost) as y,
                                        date_format(created_at,'%b %d') as x
                                FROM customer_product_bills
                                where prod_type = '".$type->prod_type."'
                                group by date_format(created_at,'%b %d')");

            array_push($data,[
                'type' => "splineArea", 
                'showInLegend' => true,
                'name' => $type->prod_type,
                'dataPoints' => $details
            ]);
        }

        return $data;
    }

    public function SalesOverDiscount()
    {
        $date = Carbon::now();
        $year_now = $date->format('Y');

        $discounts = DB::select("SELECT sum(discount)/sum(sub_total)*100 as y,
                                        date_format(created_at,'%Y-%m-%d') as label
                                FROM sales
                                where left(created_at,4) = '".$year_now."'
                                group by date_format(created_at,'%Y-%m-%d')
                                order by date_format(created_at,'%Y-%m-%d') asc");

        $total_sale = DB::select("SELECT sum(total_sale)/sum(sub_total)*100 as y,
                                        date_format(created_at,'%Y-%m-%d') as label
                                FROM sales
                                where left(created_at,4) = '".$year_now."'
                                group by date_format(created_at,'%Y-%m-%d')
                                order by date_format(created_at,'%Y-%m-%d') asc");

        $details = [
            [
                'type' => "column",
                'name' => "Sales",
                'legendText' => "Percentage sales per month.",
                'showInLegend' =>  true, 
                'dataPoints' => $total_sale
            ],
            [
                'type' => "column",
                'name' => "Discount",
                'legendText' =>  "Percentage discount per month.",
                'showInLegend' =>  true, 
                'dataPoints' => $discounts
            ],
        ]; 

        $data = [
            'details' => $details
        ];

        return response()->json($data);
    }

    public function SalesFromCustomerReport()
    {
        $date = Carbon::now();
        $month_now = $date->format('Y-m');

        $data = DB::select("SELECT concat(u.firstname,' ',u.lastname) as label,
                                    u.photo as url,
                                    sum(s.total_sale) as y
                                FROM sales as s
                                inner join customers as c
                                on s.customer_code = c.customer_code
                                inner join users as u
                                on c.user_id = u.id
                                where WEEK(s.created_at) = WEEK(CURRENT_DATE())
                                group by concat(u.firstname,' ',u.lastname),u.photo
                                order by sum(s.total_sale) asc");
        return response()->json($data);
    }

    public function YearlyComparisonReport()
    {
        $date = Carbon::now();
        $year_now = $date->format('Y');
        $last_year = $date->subYear()->format('Y');

        $last_data = DB::select("SELECT date_format(created_at,'%b') as label,
                                    sum(total_sale) as y
                                FROM sales
                                where left(created_at,4) = ".$last_year."
                                group by date_format(created_at,'%m'),
                                        date_format(created_at,'%b')
                                order by date_format(created_at,'%m') asc");

        $now_data = DB::select("SELECT date_format(created_at,'%b') as label,
                                    sum(total_sale) as y
                                FROM sales
                                where left(created_at,4) = ".$year_now."
                                group by date_format(created_at,'%m'),
                                        date_format(created_at,'%b')
                                order by date_format(created_at,'%m') asc");

        $details = [
            [
                'type' => "column",
                'name' => $last_year,
                'legendText' =>  "Sales of ".$last_year,
                'showInLegend' =>  true, 
                'dataPoints' => $last_data
            ],
            [
                'type' => "column",
                'name' => $year_now,
                'legendText' =>  "Sales of ".$year_now,
                'showInLegend' =>  true, 
                'dataPoints' => $now_data
            ],
            
        ]; 

        $data = [
            'year_now' => $year_now,
            'last_year' => $last_year,
            'details' => $details
        ];

        return response()->json($data);
    }

    public function SalesFromCustomerExcel(Request $req)
    {
        $date = date('Ymd');

        $this->_userlog->log([
            'module' => 'Sales per Customer',
            'action' => 'Donwloaded a Sales per Customer file dated '.date('Y-m-d'),
            'user_id' => Auth::user()->id
        ]);

        Excel::create('Sales_Per_Customer_'.$date, function($excel) use($req)
        {
            $excel->sheet('Report', function($sheet) use($req)
            {
                $sheet->setHeight(1, 15);
                $sheet->mergeCells('A1:C1');
                $sheet->cells('A1:C1', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true,
                    ]);
                });
                $sheet->cell('A1'," SWING SPACE");

                $sheet->setHeight(2, 15);
                $sheet->mergeCells('A2:C2');
                $sheet->cells('A2:C2', function($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->setHeight(4, 20);
                $sheet->mergeCells('A4:C4');
                $sheet->cells('A4:C4', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true,
                        'underline'  =>  true
                    ]);
                });
                $sheet->cell('A4',"Sales per Customer");

               

                $date_from = $this->_global->convertDate($req->date_from,'Y-m-d');
                $date_to = $this->_global->convertDate($req->date_to,'Y-m-d');

                $sales = DB::select("select date_format(created_at,'%b %d, %Y') as dates
                            FROM customer_product_bills
                            where left(created_at,10) between '".$date_from."' and '".$date_to."'
                            group by date_format(created_at,'%b %d, %Y')
                            order by date_format(created_at,'%b %d, %Y');");

                $row = 6;
                foreach ($sales as $key => $sale) {
                    $sheet->cell('A'.$row, $sale->dates);
                    $cust = DB::select("SELECT concat(u.firstname,' ',u.lastname) as cust_name,
                                                concat('₱', format(sum(cost), 2)) as total_sale,
                                                date_format(b.created_at,'%b %d, %Y') as dates
                                        FROM customer_product_bills as b
                                        inner join users as u
                                        on u.id = b.customer_user_id
                                        where date_format(b.created_at,'%b %d, %Y') = '".$sale->dates."'
                                        group by concat(u.firstname,' ',u.lastname),
                                                date_format(b.created_at,'%b %d, %Y')
                                        order by date_format(b.created_at,'%b %d, %Y')");
                    $row++;
                    foreach ($cust as $key => $c) {
                        $sheet->cell('B'.$row, $c->cust_name);
                        $sheet->cell('C'.$row, $c->total_sale);
                        $row++;
                    }
                }
                
                // $sheet->cells('A6:C'.$row, function($cells) {
                //     $cells->setBorder('solid', 'solid', 'solid', 'solid');
                // });
            });
        })->download('xlsx');
    }

    public function SalesOverDiscountExcel(Request $req)
    {
        $date = date('Ymd');

        $this->_userlog->log([
            'module' => 'Sales vs Discount',
            'action' => 'Donwloaded an Sales vs Discount file dated '.date('Y-m-d'),
            'user_id' => Auth::user()->id
        ]);

        Excel::create('Sales_vs_Discount_'.$date, function($excel) use($req)
        {
            $excel->sheet('Report', function($sheet) use($req)
            {
                $sheet->setHeight(1, 15);
                $sheet->mergeCells('A1:D1');
                $sheet->cells('A1:D1', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true,
                    ]);
                });
                $sheet->cell('A1'," SWING SPACE");

                $sheet->setHeight(2, 15);
                $sheet->mergeCells('A2:D2');
                $sheet->cells('A2:D2', function($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->setHeight(4, 20);
                $sheet->mergeCells('A4:D4');
                $sheet->cells('A4:D4', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true,
                        'underline'  =>  true
                    ]);
                });
                $sheet->cell('A4',"Sales vs Discount");

               

                $date_from = $this->_global->convertDate($req->date_from,'Y-m-d');
                $date_to = $this->_global->convertDate($req->date_to,'Y-m-d');

                $sales = DB::select("select date_format(created_at,'%b %d, %Y') as dates
                            FROM customer_product_bills
                            where left(created_at,10) between '".$date_from."' and '".$date_to."'
                            group by date_format(created_at,'%b %d, %Y')
                            order by date_format(created_at,'%b %d, %Y');");

                $row = 6;
                foreach ($sales as $key => $sale) {
                    $sheet->cell('A'.$row, $sale->dates);
                    $prod = DB::select("SELECT b.prod_code as prod_code,
                                                b.prod_name as prod_name,
                                                concat('₱', format(b.cost, 2)) as amount,
                                                date_format(b.created_at,'%b %d, %Y') as dates
                                        FROM customer_product_bills as b
                                        where date_format(b.created_at,'%b %d, %Y') = '".$sale->dates."'
                                        group by b.prod_code,
                                                b.prod_name,
                                                b.cost,
                                                date_format(b.created_at,'%b %d, %Y')
                                        order by date_format(b.created_at,'%b %d, %Y')");
                    $row++;
                    foreach ($prod as $key => $p) {
                        $sheet->cell('B'.$row, $p->prod_code);
                        $sheet->cell('C'.$row, $p->prod_name);
                        $sheet->cell('D'.$row, $p->amount);
                        $row++;
                    }

                    $total = DB::select("SELECT concat('₱', format(sum(sub_total), 2)) as sub_total,
                                                concat('₱', format(sum(discount), 2)) as discount,
                                                concat('₱', format(sum(total_sale), 2)) as total_sale
                                        FROM sales
                                        where date_format(created_at,'%b %d, %Y') = '".$sale->dates."'");

                    $sheet->cell('C'.$row, 'Sub Total:');
                    $sheet->cell('D'.$row, $total[0]->sub_total);
                    $row++;
                    $sheet->cell('C'.$row, 'Discount:');
                    $sheet->cell('D'.$row, $total[0]->discount);
                    $row++;
                    $sheet->cell('C'.$row, 'Total Sale:');
                    $sheet->cell('D'.$row, $total[0]->total_sale);
                    $row++;
                }
                
                // $sheet->cells('A6:D'.$row, function($cells) {
                //     $cells->setBorder('solid', 'solid', 'solid', 'solid');
                // });
            });
        })->download('xlsx');
    }

    public function YearlyComparisonExcel()
    {

    }
}
