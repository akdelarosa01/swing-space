<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\ItemInput;
use App\Inventory;
use App\DropdownOption;
use Excel;
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

    public function upload_inventory(Request $req)
    {
        $file = $req->file('inventory_file');
        $fields;

        $data = [
            'msg' => "Uploading Failed.",
            'status' => 'failed'
        ];

        Excel::load($file, function($reader) use(&$fields){
            $fields = $reader->toArray();
            $data = [
                'msg' => "Data was successfully saved.",
                'status' => 'success'
            ];
        });

        foreach ($fields as $key => $field) {
            if (isset($field['item_name']) || 
                isset($field['item_type']) || 
                isset($field['quantity']) || 
                isset($field['minimum_stock']) || 
                isset($field['uom'])) {

                $checkType = DropdownOption::where('dropdown_id',2)
                                        ->where('option_description',$field['item_type'])
                                        ->count();
                if ($checkType == 0) {
                    DropdownOption::create([
                        'dropdown_id' => 2,
                        'option_description' => $field['item_type'],
                        'create_user' => Auth::user()->id,
                        'update_user' => Auth::user()->id,
                    ]);
                 }

                $checkUOM = DropdownOption::where('dropdown_id',4)
                                        ->where('option_description',$field['uom'])
                                        ->count();
                if ($checkUOM == 0) {
                    DropdownOption::create([
                        'dropdown_id' => 2,
                        'option_description' => $field['uom'],
                        'create_user' => Auth::user()->id,
                        'update_user' => Auth::user()->id,
                    ]);
                 }

                $item = new ItemInput;

                $item->item_code = $this->_global->TransactionNo('ITM_CODE');
                $item->item_name = $field['item_name'];
                $item->item_type = $field['item_type'];
                $item->quantity = $field['quantity'];
                $item->uom = $field['uom'];
                $item->remarks = (!isset($field['remarks']) || $field['remarks'] == null || $field['remarks'] == '')? 'N/A': $field['remarks'];
                $item->transaction_type = 'Input';
                $item->create_user = Auth::user()->id;
                $item->update_user = Auth::user()->id;
                $item->date_received = date('Y-m-d');

                if ($item->save()) {
                    $inv = new Inventory;

                    $inv->item_code = $item->item_code;
                    $inv->item_type = $field['item_type'];
                    $inv->quantity = $field['quantity'];
                    $inv->minimum_stock = $field['minimum_stock'];
                    $inv->uom = $field['uom'];
                    $inv->create_user = Auth::user()->id;
                    $inv->update_user = Auth::user()->id;

                    $inv->save();

                    $data = [
                        'msg' => 'Items are successfully uploaded.',
                        'status' => 'success',
                        'inventory' => ''
                    ];
                }
            }
        }

        return json_encode($data);
    }

    public function download_upload_format()
    {
        Excel::create('inventory_upload_format', function($excel)
        {
            $excel->sheet('Report', function($sheet)
            {
                $sheet->setHeight(1, 15);
                $sheet->cell('A1', "item_name");
                $sheet->cell('B1', "item_type");
                $sheet->cell('C1', "quantity");
                $sheet->cell('D1', "minimum_stock");
                $sheet->cell('E1', "UOM");
                $sheet->cell('F1', "remarks");
            });
        })->download('xlsx');
    }
}
