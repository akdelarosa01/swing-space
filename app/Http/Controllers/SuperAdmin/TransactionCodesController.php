<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\TransactionCode;

class TransactionCodesController extends Controller
{
    protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }

    public function index()
    {
        return view('super_admin.transaction_codes');
    }

    public function save(Request $req)
    {
        $data = [
            'msg' => 'Saving failed.',
            'status' => 'failed',
            'trans' => ''
        ];

        if (isset($req->id)) {
            $this->validate($req,[
                'code' => 'required',
                'description' => 'required',
                'prefix' => 'required',
                'prefix_format' => 'required',
                'next_no' => 'required|numeric',
                'next_no_length' => 'required|numeric'
            ]);

            $tran = TransactionCode::find($req->id);

            $tran->code = $req->code;
            $tran->description = $req->description;
            $tran->prefix = $req->prefix;
            $tran->prefix_format = $req->prefix_format;
            $tran->next_no = $req->next_no;
            $tran->next_no_length = $req->next_no_length;
            $tran->update_user = Auth::user()->id;

            if ($tran->update()) {
                $data = [
                    'msg' => 'Successfully updated.',
                    'status' => 'success',
                    'trans' => $this->transaction_codes()
                ];
            } else {
                $data = [
                    'msg' => 'No changes made.',
                    'status' => 'success',
                    'trans' => $this->transaction_codes()
                ];
            }
        } else {
            $this->validate($req,[
                'code' => 'required',
                'description' => 'required',
                'prefix' => 'required',
                'prefix_format' => 'required',
                'next_no' => 'required|numeric',
                'next_no_length' => 'required|numeric'
            ]);

            $tran = new TransactionCode;

            $tran->code = $req->code;
            $tran->description = $req->description;
            $tran->prefix = $req->prefix;
            $tran->prefix_format = $req->prefix_format;
            $tran->next_no = $req->next_no;
            $tran->next_no_length = $req->next_no_length;
            $tran->create_user = Auth::user()->id;
            $tran->update_user = Auth::user()->id;

            if ($tran->save()) {
                $data = [
                    'msg' => 'Successfully saved.',
                    'status' => 'success',
                    'trans' => $this->transaction_codes()
                ];
            } else {
                $data = [
                    'msg' => 'Saving failed.',
                    'status' => 'failed',
                    'trans' => $this->transaction_codes()
                ];
            }
        }

        return response()->json($data);
    }

    public function show()
    {
        $tran = $this->transaction_codes();
        return response()->json($tran);
    }

    public function destroy(Request $req)
    {
        $data = [
            'msg' => 'Deleting failed.',
            'status' => 'failed',
            'trans' => ''
        ];

        $tran = TransactionCode::find($req->id);

        if ($tran->delete()) {
            $data = [
                'msg' => 'Successfully deleted.',
                'status' => 'success',
                'trans' => $this->transaction_codes()
            ];
        }

        return response()->json($data);
    }

    private function transaction_codes()
    {
        $tran = TransactionCode::orderBy('id','desc')->get();
        return $tran;
    }
}
