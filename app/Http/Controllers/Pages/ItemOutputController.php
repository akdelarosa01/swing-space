<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\SuperAdmin\UserLogsController;
use App\ItemOutput;
use App\Inventory;
use DB;

class ItemOutputController extends Controller
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
        if ($this->_global->checkAccess('ITM_OUT')) {
            return view('pages.inventory.item_output',[
                'user_access' => $this->_global->UserAccess()
            ]);
        } else {
            return redirect('/dashboard');
        }
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
                        ->decrement('quantity',$req->selected_quantity[$key]);
            }

            foreach ($req->selected_code as $key => $selected_code) {
                $item = ItemOutput::create([
                        'item_code' => $selected_code,
                        'item_name' => $req->selected_name[$key],
                        'item_type' => $req->selected_type[$key],
                        'quantity' => $req->selected_quantity[$key],
                        'uom' => $req->selected_uom[$key],
                        'remarks' => 'N/A',
                        'transaction_type' => 'Output',
                        'create_user' => Auth::user()->id,
                        'update_user' => Auth::user()->id,
                    ]);
            }

            $item_names = implode(',', $req->selected_name);
            $item_count = count($req->selected_name);
            $noun = 'this item';
            if ($item_count > 1) {
                $noun = 'these items';
            }

            $this->_userlog->log([
                'module' => 'Item Output',
                'action' => 'Output '.$noun.' '.$item_names,
                'user_id' => Auth::user()->id
            ]);
        }

        if ($item) {
            $data = [
                'msg' => 'Items are successfully out from the inventory.',
                'status' => 'success',
                'item_type' => $req->selected_type[0]
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
                        DB::raw("inv.quantity as quantity"),
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
                $item = ItemOutput::find($id);
                $item->deleted = 1;

                if ($item->update()) {
                    $data = [
                        'msg' => 'Items are successfully deleted.',
                        'status' => 'success',
                        'inventory' => ''
                    ];
                }
            }

            $item_id = implode(',', $req->id);
            $item_count = count($req->id);
            $noun = 'this item ID';
            if ($item_count > 1) {
                $noun = 'these items ID';
            }

            $this->_userlog->log([
                'module' => 'Item Output',
                'action' => 'Deleted '.$noun.' '.$item_id,
                'user_id' => Auth::user()->id
            ]);
        } else {
            $item = ItemOutput::find($req->id);
            $item->deleted = 1;

            if ($item->update()) {
                $this->_userlog->log([
                    'module' => 'Item Output',
                    'action' => 'Deleted this item ID '.$req->id,
                    'user_id' => Auth::user()->id
                ]);

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
