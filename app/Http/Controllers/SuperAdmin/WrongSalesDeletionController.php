<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\CustomerProductBill;
use App\Sale;
use DB;

class WrongSalesDeletionController extends Controller
{
    protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }

    public function index()
    {
        return view('super_admin.wrong_sales_deletion',[
                'user_access' => $this->_global->UserAccess()
            ]);
    }

    public function getSoldProducts()
    {
    	$prods = DB::select("SELECT id,
								customer_code,
							    firstname,
							    lastname,
							    prod_code,
							    prod_name,
							    prod_type,
							    variants,
							    quantity,
							    cost,
							    if(customer_type = 'M', 'Member','Walk-in') as customer_type,
							    DATE_FORMAT(created_at, '%Y/%m/%d %h:%i %p') as created_at
							FROM customer_product_bills ORDER BY created_at DESC");
    	return response()->json($prods);
    }

    public function deleteSoldProducts(Request $req)
    {
        $data = [
            'msg' => 'Deleting failed.',
            'status' => 'failed'
        ];

        if (is_array($req->ids)) {
            foreach ($req->ids as $key => $id) {
                $cpb = CustomerProductBill::find($id);

                if ($cpb->delete()) {
                    $data = [
                        'msg' => 'Successfully deleted.',
                        'status' => 'success'
                    ];
                }
            }

        } else {
            $cpb = CustomerProductBill::find($req->id);

            if ($cpb->delete()) {

                $data = [
                    'msg' => 'Successfully deleted.',
                    'status' => 'success'
                ];
            }
        }

        return response()->json($data);
    }

    public function getSales()
    {
    	$sales = DB::select("SELECT id,
								customer_code,
							    firstname,
							    lastname,
							    if(customer_type = 'M', 'Member','Walk-in') as customer_type,
							    sub_total,
							    discount,
							    payment,
							    `change`,
							    total_sale,
							    DATE_FORMAT(created_at, '%Y/%m/%d %h:%i %p') as created_at
							FROM sales ORDER BY created_at DESC");
    	return response()->json($sales);
    }

    public function deleteSales(Request $req)
    {
        $data = [
            'msg' => 'Deleting failed.',
            'status' => 'failed'
        ];

        if (is_array($req->ids)) {
            foreach ($req->ids as $key => $id) {
                $sale = Sale::find($id);

                if ($sale->delete()) {
                    $data = [
                        'msg' => 'Successfully deleted.',
                        'status' => 'success'
                    ];
                }
            }

        } else {
            $sale = Sale::find($req->id);

            if ($sale->delete()) {

                $data = [
                    'msg' => 'Successfully deleted.',
                    'status' => 'success'
                ];
            }
        }

        return response()->json($data);
    }
}
