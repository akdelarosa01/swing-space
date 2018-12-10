<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\AvailableProduct;
use App\Product;
use Excel;
use DB;
use PDF;

class ProductController extends Controller
{
     protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }

    public function index()
    {
        if ($this->_global->checkAccess('PRD_LST')) {
            return view('pages.products.product_list',[
                'user_access' => $this->_global->UserAccess()
            ]);
        } else {
            return redirect('/dashboard');
        }
    }

    public function add_products()
    {
        if ($this->_global->checkAccess('PRD_REG')) {
            return view('pages.products.add_products',[
                'user_access' => $this->_global->UserAccess()
            ]);
        } else {
            return redirect('/dashboard');
        }
    }

    public function show()
    {
        $products = $this->products();
        return response()->json($products);
    }

    public function save(Request $req)
    {
        $data = [
            'msg' => 'Saving failed.',
            'status' => 'failed',
            'products' => ''
        ];

        if (isset($req->id)) {
            $this->validate($req,[
                'prod_name' => 'required|string|max:60',
                'prod_type' => 'required',
                'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            ]);

            $prod = Product::find($req->id);

            $prod->prod_name = $req->prod_name;
            $prod->description = $req->description;
            $prod->prod_type = $req->prod_type;
            $prod->variants = $req->variants;
            $prod->price = $req->price;
            $prod->create_user = Auth::user()->id;
            $prod->update_user = Auth::user()->id;

            if ($prod->update()) {

                $data = [
                    'msg' => 'Product is successfully updated.',
                    'status' => 'success',
                    'products' => $this->products()
                ];
            }
        } else {
            $this->validate($req,[
                'prod_name' => 'required|string|max:60',
                'prod_type' => 'required',
                'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            ]);

            $prod = new Product;

            $prod->prod_code = $this->_global->TransactionNo('PRD_CODE');
            $prod->prod_name = $req->prod_name;
            $prod->description = $req->description;
            $prod->prod_type = $req->prod_type;
            $prod->variants = $req->variants;
            $prod->price = $req->price;
            $prod->create_user = Auth::user()->id;
            $prod->update_user = Auth::user()->id;

            if ($prod->save()) {

                $data = [
                    'msg' => 'Product is successfully saved.',
                    'status' => 'success',
                    'products' => $this->products()
                ];
            }
        } 

        return response()->json($data);
    }

    public function set_qty(Request $req)
    {
        $queried = false;

        $data = [
            'msg' => 'Saving failed.',
            'status' => 'failed',
            'products' => ''
        ];

        if (isset($req->ids)) {
            if (is_array($req->ids)) {
                foreach ($req->ids as $key => $id) {
                    $count = AvailableProduct::where('prod_id',$id)->count();

                    if ($count > 0) {
                        AvailableProduct::where('prod_id',$id)
                                        ->update([
                                            'target_qty' => $req->target_qty[$key],
                                            'quantity' => $req->quantity[$key],
                                            'update_user' => Auth::user()->id,
                                            'updated_at' => date('Y-m-d H:i:s')
                                        ]);
                    } else {
                        AvailableProduct::create([
                            'prod_id' => $id,
                            'target_qty' => $req->target_qty[$key],
                            'quantity' => $req->quantity[$key],
                            'create_user' => Auth::user()->id,
                            'update_user' => Auth::user()->id,
                        ]);
                    }

                    $queried = true;
                }
            }
        }

        if ($queried) {
            $data = [
                'msg' => 'Successfully saved.',
                'status' => 'success',
                'products' => $this->products()
            ];
        }

        return response()->json($data);
    }

    public function products($type = '')
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

    public function search_products()
    {
        $products = $this->products();
        return response()->json($products);
    }

    public function destroy(Request $req)
    {
        $data = [
            'msg' => "Deleting failed",
            'status' => "warning"
        ];

        if (is_array($req->id)) {
            foreach ($req->id as $key => $id) {
                $prod = Product::find($id);
                $prod->delete();

                $data = [
                    'msg' => "Product was successfully deleted.",
                    'status' => "success",
                    'products' => $this->products()
                ];
            }
        } else {
            $ids = explode(',', $req->id);

            foreach ($ids as $key => $id) {
                $prod = Product::find($id);
                $prod->delete();
            }

            

            $data = [
                'msg' => "Products was successfully deleted.",
                'status' => "success",
                'products' => $this->products()
            ];
        }
        return response()->json($data);
    }

    public function export_files(Request $req)
    {
        $data;

        if(empty($req->prod_type))
        {
            $data = $this->products();
        } else {
            $data = $this->products($req->prod_type);
        }

        switch ($req->file_type) {
            case 'PDF':
                return $this->pdfFile($data);
                break;
            
            default:
                return $this->excelfile($data);
                break;
        }
    }

    public function excelfile($data)
    {
        $date = date('Ymd');

        Excel::create('Product_List_'.$date, function($excel) use($data)
        {
            $excel->sheet('Report', function($sheet) use($data)
            {
                $sheet->setHeight(1, 15);
                $sheet->mergeCells('A1:I1');
                $sheet->cells('A1:I1', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true,
                    ]);
                });
                $sheet->cell('A1'," SWING SPACE");

                $sheet->setHeight(2, 15);
                $sheet->mergeCells('A2:I2');
                $sheet->cells('A2:I2', function($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->cell('A2',"Unit 2 Mezzanine, Burgundy Place, B. Gonzales St., Loyola Heights Katipunan, Quezon City");

                $sheet->setHeight(4, 20);
                $sheet->mergeCells('A4:I4');
                $sheet->cells('A4:I4', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true,
                        'underline'  =>  true
                    ]);
                });
                $sheet->cell('A4',"PRODUCT LIST");

                $sheet->setHeight(6, 15);
                $sheet->cells('A6:I6', function($cells) {
                    $cells->setFont([
                        'family'     => 'Calibri',
                        'size'       => '11',
                        'bold'       =>  true,
                    ]);
                    // Set all borders (top, right, bottom, left)
                    $cells->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('A6', "PRODUCT CODE");
                $sheet->cell('B6', "PRODUCT NAME");
                $sheet->cell('C6', "DESCRIPTION");
                $sheet->cell('D6', "PRODUCT TYPE");
                $sheet->cell('E6', "PRICE");
                $sheet->cell('F6', "VARIANT");
                $sheet->cell('G6', "TARGET QTY.");
                $sheet->cell('H6', "AVAILABLE QTY");
                $sheet->cell('I6', "UPDATED AT");

                $row = 7;

                foreach ($data as $key => $dt) {
                    $sheet->setHeight($row, 15);
                    $sheet->cell('A'.$row, function($cell) use($dt) {
                        $cell->setValue($dt->prod_code);
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $sheet->cell('B'.$row, function($cell) use($dt) {
                        $cell->setValue($dt->prod_name);
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $sheet->cell('C'.$row, function($cell) use($dt) {
                        $cell->setValue($dt->description);
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $sheet->cell('D'.$row, function($cell) use($dt) {
                        $cell->setValue($dt->prod_type);
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $sheet->cell('E'.$row, function($cell) use($dt) {
                        $cell->setValue($dt->price);
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $sheet->cell('F'.$row, function($cell) use($dt) {
                        $cell->setValue($dt->variants);
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $sheet->cell('G'.$row, function($cell) use($dt) {
                        $cell->setValue($dt->target_qty);
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $sheet->cell('H'.$row, function($cell) use($dt) {
                        $cell->setValue($dt->quantity);
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $sheet->cell('I'.$row, function($cell) use($dt) {
                        $cell->setValue($dt->updated_at);
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $row++;
                }
                
                $sheet->cells('A6:I'.$row, function($cells) {
                    $cells->setBorder('solid', 'solid', 'solid', 'solid');
                });
            });
        })->download('xlsx');
    }

    public function pdfFile($data)
    {
        $pdf = PDF::loadView('pdf.product', ['data'=>$data])
                        ->setPaper('A4')
                        ->setOrientation('landscape');
        return $pdf->inline('prodtuct');
    }
}
