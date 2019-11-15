<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\SuperAdmin\UserLogsController;
use App\User;
use App\Customer;
use Excel;
use DB;

class CustomerController extends Controller
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
        if ($this->_global->checkAccess('CUS_LST')) {
            return view('pages.customer.customer_list',[
                'user_access' => $this->_global->UserAccess()
            ]);
        } else {
            return redirect('/dashboard');
        }
    }

    public function show()
    {
        $customers = DB::table('users as u')
                        ->join('customers as c','u.id','=','c.user_id')
                        ->where('u.disabled',0)
                        ->orderBy('u.id')
                        ->select(
                            DB::raw('u.id as id'),
                            DB::raw('u.photo as photo'),
                            DB::raw('u.firstname as firstname'),
                            DB::raw('u.lastname as lastname'),
                            DB::raw('u.email as email'),
                            DB::raw('u.gender as gender'),
                            DB::raw('c.customer_code as customer_code'),
                            DB::raw('date_format(c.date_of_birth,"%b %d, %Y") as date_of_birth'),
                            DB::raw('c.phone as phone'),
                            DB::raw('c.mobile as mobile'),
                            DB::raw('c.facebook as facebook'),
                            DB::raw('c.instagram as instagram'),
                            DB::raw('c.twitter as twitter'),
                            DB::raw('c.occupation as occupation'),
                            DB::raw('c.company as company'),
                            DB::raw('c.school as school'),
                            DB::raw("(select ifnull(concat(us.firstname,' ',us.lastname),'N/A')
                                    from users as us where us.id = c.referrer) as referrer"),
                            DB::raw('c.points as points'),
                            DB::raw('c.membership_type as membership_type'),
                            DB::raw('date_format(c.date_registered,"%b %d, %Y") as date_registered')
                        )
                        ->get();
        return response()->json($customers);
    }

    public function destroy(Request $req)
    {
        $data = [
            'msg' => 'Deleting failed.',
            'status' => 'failed',
            'customers' => ''
        ];

        if (isset($req->id)) {

            $cust = Customer::where('user_id',$req->id)->first();

            $this->_userlog->log([
                'module' => 'Customer List',
                'action' => 'Delete Customer code: '.$cust->customer_code.', User ID: '.$req->id,
                'user_id' => Auth::user()->id
            ]);

            $user = User::find($req->id);
            $user->disabled = 1;
            if ($user->update()) {
                $customers = DB::table('users as u')
                        ->join('customers as c','u.id','=','c.user_id')
                        ->where('u.disabled',0)
                        ->orderBy('u.id')
                        ->select(
                            DB::raw('u.id as id'),
                            DB::raw('u.photo as photo'),
                            DB::raw('u.firstname as firstname'),
                            DB::raw('u.lastname as lastname'),
                            DB::raw('u.email as email'),
                            DB::raw('u.gender as gender'),
                            DB::raw('c.customer_code as customer_code'),
                            DB::raw('date_format(c.date_of_birth,"%b %d, %Y") as date_of_birth'),
                            DB::raw('c.phone as phone'),
                            DB::raw('c.mobile as mobile'),
                            DB::raw('c.facebook as facebook'),
                            DB::raw('c.instagram as instagram'),
                            DB::raw('c.twitter as twitter'),
                            DB::raw('c.occupation as occupation'),
                            DB::raw('c.company as company'),
                            DB::raw('c.school as school'),
                            DB::raw("(select ifnull(concat(us.firstname,' ',us.lastname),'N/A')
                                    from users as us where us.id = c.referrer) as referrer"),
                            DB::raw('c.points as points'),
                            DB::raw('c.membership_type as membership_type'),
                            DB::raw('date_format(c.date_registered,"%b %d, %Y") as date_registered')
                        )
                        ->get();

                $data = [
                    'msg' => 'Successfully deleted.',
                    'status' => 'success',
                    'customers' => $customers
                ];
            }
        }

        return response()->json($data);
    }

    public function customerListExcel()
    {
        $date = date('Ymd');

        $this->_userlog->log([
            'module' => 'Customer List',
            'action' => 'Donwloaded Customer list on '.date('Y-m-d'),
            'user_id' => Auth::user()->id
        ]);

        Excel::create('Customer_List_'.$date, function($excel)
        {
            $excel->sheet('List', function($sheet)
            {
                $sheet->setHeight(1, 15);
                $sheet->mergeCells('A1:L1');
                $sheet->cells('A1:L1', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '15',
                        'bold'       =>  true,
                    ]);
                });
                $sheet->cell('A1'," SWING SPACE");

                $sheet->setHeight(2, 15);
                $sheet->mergeCells('A2:L2');
                $sheet->cells('A2:L2', function($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->setHeight(4, 20);
                $sheet->mergeCells('A4:L4');
                $sheet->cells('A4:L4', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true,
                        'underline'  =>  true
                    ]);
                });

                $sheet->cell('A4',"List of Customer");

                $sheet->setHeight(6, 20);
                $sheet->cells('A6:L6', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true
                    ]);
                    // Set all borders (top, right, bottom, left)
                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                    $cells->setBackground('#226597');
                    $cells->setFontColor('#fdfdfd');
                });

                $sheet->cell('B6', 'Customer Code');
                $sheet->cell('C6', 'Name');
                $sheet->cell('D6', 'Email');
                $sheet->cell('E6', 'Date of Birth');
                $sheet->cell('F6', 'Phone');
                $sheet->cell('G6', 'Mobile');
                $sheet->cell('H6', 'Occupation');
                $sheet->cell('I6', 'School');
                $sheet->cell('J6', 'Referrer');
                $sheet->cell('K6', 'Points');
                $sheet->cell('L6', 'Date Registered');

                $custs = DB::select("SELECT 
                                    c.customer_code as customer_code,
                                    CONCAT(u.firstname,' ',u.lastname) as user_name,
                                    u.email as email,
                                    date_format(c.date_of_birth,'%b %d, %Y') as date_of_birth,
                                    ifnull(c.phone,'') as phone,
                                    ifnull(c.mobile,'') as mobile,
                                    ifnull(c.occupation,'') as occupation,
                                    ifnull(c.school,'') as school,
                                    ifnull((select CONCAT(u1.firstname,' ',u1.lastname)
                                    from users u1
                                    where u1.id = c.referrer),'') as referrer,
                                    if(c.points <> 0,c.points,'0.00') as points,
                                    date_format(c.date_registered,'%b %d, %Y') as date_registered
                                    FROM swingspace.customers c
                                    inner join users u
                                    on u.id = c.user_id");

                $row = 7;
                foreach ($custs as $key => $cust) {

                    $sheet->cells('A'.$row.':L'.$row, function($cells) use($row) {
                        $cells->setAlignment('left');
                        $cells->setFont([
                            'family'     => 'Calibri',
                            'size'       => '14',
                        ]);
                        $cells->setBorder('thin', 'thin', 'thin', 'thin');

                        if ($row % 2 == 0) {
                            $cells->setBackground('#f3f9fb');
                        } else {
                            $cells->setBackground('#87c0cd');
                        }
                    });

                    $sheet->cell('B'.$row, $cust->customer_code);
                    $sheet->cell('C'.$row, $cust->user_name);
                    $sheet->cell('D'.$row, $cust->email);
                    $sheet->cell('E'.$row, $cust->date_of_birth);
                    $sheet->cell('F'.$row, $cust->phone);
                    $sheet->cell('G'.$row, $cust->mobile);
                    $sheet->cell('H'.$row, $cust->occupation);
                    $sheet->cell('I'.$row, $cust->school);
                    $sheet->cell('J'.$row, $cust->referrer);
                    $sheet->cell('K'.$row, $cust->points);
                    $sheet->cell('L'.$row, $cust->date_registered);
                    $row++;
                }
            });
        })->download('xlsx');
    }
}
