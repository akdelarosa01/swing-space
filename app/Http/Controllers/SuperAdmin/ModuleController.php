<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Module;

class ModuleController extends Controller
{
    protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }

    public function index()
    {
        return view('super_admin.module',[
                'user_access' => $this->_global->UserAccess()
            ]);
    }

    public function save(Request $req)
    {
        if (isset($req->id)) {
            $this->validate($req,[
                'module_code' => 'required|max:50',
                'module_name' => 'required|max:50',
                'module_category' => 'required|max:50',
                'icon' => 'required|max:50'
            ]);

            $mod = Module::find($req->id);

            $mod->module_code = $req->module_code;
            $mod->module_name = $req->module_name;
            $mod->module_category = $req->module_category;
            $mod->icon = $req->icon;
            $mod->update_user = Auth::user()->id;

            $mod->update();
        } else {
            $this->validate($req,[
                'module_code' => 'required|unique:modules|max:50',
                'module_name' => 'required|unique:modules|max:50',
                'module_category' => 'required|max:50',
                'icon' => 'required|max:50'
            ]);

            $mod = new Module;

            $mod->module_code = $req->module_code;
            $mod->module_name = $req->module_name;
            $mod->module_category = $req->module_category;
            $mod->icon = $req->icon;
            $mod->create_user = Auth::user()->id;
            $mod->update_user = Auth::user()->id;

            $mod->save();
        }

        $mods = Module::orderBy('id','desc')->get();
        return response()->json($mods);
    }

    public function show()
    {
        $mod = Module::orderBy('id','desc')->get();
        return response()->json($mod);
    }

    public function destroy(Request $req)
    {
        $mod = Module::find($req->id);
        $mod->delete();

        $mods = Module::orderBy('id','desc')->get();
        return response()->json($mods);
    }
}
