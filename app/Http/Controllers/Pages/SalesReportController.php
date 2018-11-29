<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\UserLogsController;
use Carbon\Carbon;
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

    public function monthlySalesPerProductReport()
    {
        $details = [
            [
                'type' => "splineArea", 
                'showInLegend' => true,
                'yValueFormatString' => "$#,##0",
                'name' => "Maintenance",
                'dataPoints' => => $last_data
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
    }

    public function SalesOverDiscount($value='')
    {
        DB::select("SELECT format((sum(discount)/sum(sub_total))*100,2) as discount,
                            format((sum(total_sale)/sum(sub_total))*100,2) as total_sale,
                            date_format(created_at,'%b %d') as months
                    FROM sales
                    group by date_format(created_at,'%b %d')");
    }

    public function SalesFromCustomerReport()
    {
        $date = Carbon::now();
        $year_now = $date->format('Y');

        $data = DB::select("SELECT concat(u.firstname,' ',u.lastname) as label,
                                    u.photo as url,
                                    sum(s.total_sale) as y
                                FROM sales as s
                                inner join customers as c
                                on s.customer_code = c.customer_code
                                inner join users as u
                                on c.user_id = u.id
                                where left(s.created_at,4) = ".$year_now."
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
}
