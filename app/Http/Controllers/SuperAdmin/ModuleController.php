<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Module;

class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $mod = Module::orderBy('id','desc')->get();
        return response()->json($mod);
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'module_code' => 'required',
            'module_name' => 'required',
            'module_category' => 'required',
            'icon' => 'required'
        ]);

        $mod = new Module;

        $mod->module_code = $req->module_code;
        $mod->module_name = $req->module_name;
        $mod->module_category = $req->module_category;
        $mod->icon = $req->icon;
        $mod->create_user = Auth::user()->id;
        $mod->update_user = Auth::user()->id;

        $mod->save();

        return response()->json($mod);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $req, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
