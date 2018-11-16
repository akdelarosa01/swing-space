<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\UserLogsController;
use Excel;
use DB;

class InventoryController extends Controller
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

    public function export_files(Request $req)
    {
        $type_cond = '';

        if(empty($req->item_type))
        {
            $type_cond = '';
        } else {
            $type_cond = " AND item_type = '" . $req->item_type . "'";
        }

        $data = DB::table('inventories as inv')
                    ->whereRaw("deleted=0".$type_cond)
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

        switch ($req->file_type) {
            case 'Excel':
                $this->excelfile($data);
                break;
            
            default:
                # code...
                break;
        }
    }

    public function excelfile($data)
    {
        $date = date('Ymd');

        $this->_userlog->log([
            'module' => 'Inventory List',
            'action' => 'Donwloaded an inventory list excel file dated '.date('Y-m-d'),
            'user_id' => Auth::user()->id
        ]);

        Excel::create('Inventory_List_'.$date, function($excel) use($data)
        {
            $excel->sheet('Report', function($sheet) use($data)
            {
                $sheet->setHeight(1, 15);
                $sheet->mergeCells('A1:F1');
                $sheet->cells('A1:F1', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true,
                    ]);
                });
                $sheet->cell('A1'," SWING SPACE");

                $sheet->setHeight(2, 15);
                $sheet->mergeCells('A2:F2');
                $sheet->cells('A2:F2', function($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->cell('A2',"Unit 2 Mezzanine, Burgundy Place, B. Gonzales St., Loyola Heights Katipunan, Quezon City");

                $sheet->setHeight(4, 20);
                $sheet->mergeCells('A4:F4');
                $sheet->cells('A4:F4', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true,
                        'underline'  =>  true
                    ]);
                });
                $sheet->cell('A4',"INVENTORY LIST");

                $sheet->setHeight(6, 15);
                $sheet->cells('A6:F6', function($cells) {
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '11',
                        'bold'       =>  true,
                    ]);
                    // Set all borders (top, right, bottom, left)
                    $cells->setBorder('solid', 'solid', 'solid', 'solid');
                });
                $sheet->cell('A6', "ITEM CODE");
                $sheet->cell('B6', "ITEM NAME");
                $sheet->cell('C6', "ITEM TYPE");
                $sheet->cell('D6', "QUANTITY");
                $sheet->cell('E6', "MINIMUM STOCK");
                $sheet->cell('F6', "UOM");

                $row = 7;

                foreach ($data as $key => $dt) {
                    $sheet->setHeight($row, 15);
                    $sheet->cell('A'.$row, $dt->item_code);
                    $sheet->cell('B'.$row, $dt->item_name);
                    $sheet->cell('C'.$row, $dt->item_type);
                    $sheet->cell('D'.$row, $dt->quantity);
                    $sheet->cell('E'.$row, $dt->minimum_stock);
                    $sheet->cell('F'.$row, $dt->uom);
                    $row++;
                }
                
                $sheet->cells('A6:F'.$row, function($cells) {
                    $cells->setBorder('solid', 'solid', 'solid', 'solid');
                });
            });
        })->download('xlsx');
    }
}
