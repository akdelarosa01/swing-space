<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Inventory;
use App\ItemInput;
use DB;

class UpdateInventoryController extends Controller
{
    protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }

    public function index()
    {
        if ($this->_global->checkAccess('UPD_INV')) {
            return view('pages.inventory.update_inventory',[
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

    public function save(Request $req)
    {
        $data = [
            'msg' => 'Saving failed.',
            'status' => 'failed',
            'item_type' => ''
        ];

        if (is_array($req->id)) {
            foreach ($req->id as $key => $id) {
                if ($req->quantity[$key] < $req->new_qty[$key]) {
                    $inv = Inventory::find($id);
                    $inv->quantity = $req->new_qty[$key];

                    if ($inv->update()) {
                        $new_qty = $req->new_qty[$key] - $req->quantity[$key]; 
                        $item = ItemInput::create([
                            'item_code' => $req->item_code[$key],
                            'item_name' => $req->item_name[$key],
                            'item_type' => $req->item_type[$key],
                            'quantity' => $new_qty,
                            'uom' => $req->uom[$key],
                            'remarks' => 'N/A',
                            'transaction_type' => 'Adjustment',
                            'date_received' => date('Y-m-d'),
                            'create_user' => Auth::user()->id,
                            'update_user' => Auth::user()->id,
                        ]);

                        if ($item) {
                            $data = [
                                'msg' => 'Successfully updated.',
                                'status' => 'success',
                                'item_type' => $req->item_type[$key]
                            ];
                        } 
                    }
                } 

                if ($req->quantity[$key] > $req->new_qty[$key]) {
                    $inv = Inventory::find($id);
                    $inv->quantity = $req->new_qty[$key];

                    if ($inv->update()) {
                        $new_qty =  $req->quantity[$key] - $req->new_qty[$key]; 
                        $item = ItemOutput::create([
                            'item_code' => $req->item_code[$key],
                            'item_type' => $req->item_type[$key],
                            'quantity' => $new_qty,
                            'uom' => $req->uom[$key],
                            'remarks' => 'N/A',
                            'transaction_type' => 'Adjustment',
                            'create_user' => Auth::user()->id,
                            'update_user' => Auth::user()->id,
                        ]);

                        if ($item) {
                            $data = [
                                'msg' => 'Successfully updated.',
                                'status' => 'success',
                                'item_type' => $req->item_type[$key]
                            ];
                        } 
                    }
                }
            }
        }

        return response()->json($data);
    }
}
