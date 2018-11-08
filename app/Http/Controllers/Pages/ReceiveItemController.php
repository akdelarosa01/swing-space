<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\ItemInput;
use App\Inventory;
use DB;

class ReceiveItemController extends Controller
{
    protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }

    public function index()
    {
        if ($this->_global->checkAccess('RCV_ITM')) {
            return view('pages.inventory.receive_items',[
                'user_access' => $this->_global->UserAccess()
            ]);
        } else {
            return redirect('/dashboard');
        }
    }

    public function save(Request $req)
    {
        $data = [
            'msg' => 'Saving failed.',
            'status' => 'failed',
            'inventory' => ''
        ];

        $this->validate($req,[
            'item_name' => 'required|string|max:60',
            'item_type' => 'required',
            'quantity' => 'required',
            'minimum_stock' => 'required',
            'uom' => 'required',
        ]);

        $item = new ItemInput;

        $item->item_code = $this->_global->TransactionNo('ITM_CODE');
        $item->item_name = $req->item_name;
        $item->item_type = $req->item_type;
        $item->quantity = $req->quantity;
        $item->uom = $req->uom;
        $item->remarks = (!isset($req->remarks) || $req->remarks == null || $req->remarks == '')? 'N/A': $req->remarks;
        $item->transaction_type = 'Input';
        $item->create_user = Auth::user()->id;
        $item->update_user = Auth::user()->id;
        $item->date_received = date('Y-m-d');

        if ($item->save()) {
            $inv = new Inventory;

            $inv->item_code = $item->item_code;
            $inv->item_type = $req->item_type;
            $inv->quantity = $req->quantity;
            $inv->minimum_stock = $req->minimum_stock;
            $inv->uom = $req->uom;
            $inv->create_user = Auth::user()->id;
            $inv->update_user = Auth::user()->id;

            $inv->save();

            $data = [
                'msg' => 'Item is successfully saved.',
                'status' => 'success',
                'inventory' => ''
            ];
        }

        return response()->json($data);
    }

    public function save_selected(Request $req)
    {
        $data = [
            'msg' => 'Saving failed.',
            'status' => 'failed',
            'inventory' => ''
        ];

        $item;

        if (is_array($req->id)) {
            foreach ($req->id as $key => $id) {
                Inventory::where('id',$id)
                        ->increment('quantity',$req->selected_quantity[$key]);
            }

            foreach ($req->selected_code as $key => $selected_code) {
                $item = ItemInput::create([
                        'item_code' => $selected_code,
                        'item_name' => $req->selected_name[$key],
                        'item_type' => $req->selected_type[$key],
                        'quantity' => $req->selected_quantity[$key],
                        'uom' => $req->selected_uom[$key],
                        'remarks' => 'N/A',
                        'transaction_type' => 'Input',
                        'create_user' => Auth::user()->id,
                        'update_user' => Auth::user()->id,
                        'date_received' => date('Y-m-d')
                    ]);
            }
        }

        if ($item) {
            $data = [
                'msg' => 'Items are successfully saved.',
                'status' => 'success',
                'inventory' => ''
            ];
        }

        return response()->json($data);
    }

    public function search_items(Request $req)
    {
        $items = DB::table('inventories as inv')
                    ->where('inv.item_type',$req->item_type_srch)
                    ->where('inv.deleted',0)
                    ->select(
                        DB::raw("inv.id as id"),
                        DB::raw("inv.item_code as item_code"),
                        DB::raw("(SELECT itm.item_name FROM item_inputs as itm
                                    WHERE itm.item_code = inv.item_code LIMIT 1) as item_name"),
                        DB::raw("inv.item_type as item_type"),
                        DB::raw("inv.uom as uom")
                    )
                    ->get();
        return response()->json($items);
    }

    public function destroy(Request $req)
    {
        $data = [
            'msg' => 'Deleting failed',
            'status' => 'failed',
            'inventory' => ''
        ];

        if (is_array($req->id)) {
            foreach ($req->id as $key => $id) {
                $item = ItemInput::find($id);
                $item->deleted = 1;

                if ($item->update()) {
                    $data = [
                        'msg' => 'Items are successfully deleted.',
                        'status' => 'success',
                        'inventory' => ''
                    ];
                }
            }
        } else {
            $item = ItemInput::find($id);
            $item->deleted = 1;

            if ($item->update()) {
                $data = [
                    'msg' => 'Items are successfully deleted.',
                    'status' => 'success',
                    'inventory' => ''
                ];
            }
        }

        return response()->json($data);
    }
}
