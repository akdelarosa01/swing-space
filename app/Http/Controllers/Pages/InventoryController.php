<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use DB;

class InventoryController extends Controller
{
    protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }

    public function index()
    {
        if ($this->_global->checkAccess('INV_LST')) {
            return view('pages.inventory.inventory_list',[
                'user_access' => $this->_global->UserAccess()
            ]);
        } else {
            return redirect('/dashboard');
        }
    }

    public function search_items(Request $req)
    {
        $items = DB::table('inventories as inv')
                    ->where('inv.item_type',$req->item_type)
                    ->where('inv.deleted',0)
                    ->select(
                        DB::raw("inv.id as id"),
                        DB::raw("inv.item_code as item_code"),
                        DB::raw("(SELECT itm.item_name FROM item_inputs as itm
                                    WHERE itm.item_code = inv.item_code LIMIT 1) as item_name"),
                        DB::raw("inv.item_type as item_type"),
                        DB::raw("inv.quantity as quantity"),
                        DB::raw("inv.minimum_stock as minimum_stock"),
                        DB::raw("inv.uom as uom")
                    )
                    ->get();
        return response()->json($items);
    }

    public function search_summary_items(Request $req)
    {
        $inventories = DB::select(
                            "SELECT i.transaction_type,
                                i.item_code, 
                                i.item_name, 
                                i.item_type,
                                i.quantity,
                                i.uom,
                                DATE_FORMAT(i.created_at, '%Y/%m/%d %H:%i %p') as trans_date,
                                (SELECT CONCAT(u.firstname,' ',u.lastname) FROM users as u
                                WHERE u.id = i.create_user LIMIT 1) as create_user
                            FROM item_inputs as i
                            where i.item_type = '".$req->item_type."' and i.deleted = 0
                            union 
                            SELECT o.transaction_type,
                                o.item_code, 
                                o.item_name, 
                                o.item_type,
                                o.quantity,
                                o.uom,
                                DATE_FORMAT(o.created_at, '%Y/%m/%d %H:%i %p') as trans_date,
                                (SELECT CONCAT(u.firstname,' ',u.lastname) FROM users as u
                                WHERE u.id = o.create_user LIMIT 1) as create_user
                            FROM item_outputs as o
                            where o.item_type='".$req->item_type."' and o.deleted = 0
                            order by trans_date desc"
                        );

        return response()->json($inventories);
    }

    public function summary_list()
    {
        if ($this->_global->checkAccess('SUM_LST')) {
            return view('pages.inventory.summary_list',[
                'user_access' => $this->_global->UserAccess()
            ]);
        } else {
            return redirect('/dashboard');
        }
    }
}
