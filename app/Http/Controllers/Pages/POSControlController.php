<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\UserLogsController;
use App\Product;
use App\DropdownOption;
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
            return view('pages.pos',[
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
}
