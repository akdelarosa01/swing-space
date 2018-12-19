<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\SuperAdmin\UserLogsController;
use App\DropdownName;
use App\DropdownOption;

class DropdownController extends Controller
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
        if ($this->_global->checkAccess('DRP_SET')) {
            return view('pages.settings.dropdown',[
                'user_access' => $this->_global->UserAccess()
            ]);
        } else {
            return redirect('/dashboard');
        }
    }

    public function save_name(Request $req)
    {
    	$data = [
    		'msg' => 'Saving failed.',
    		'status' => 'failed',
    		'name' => ''
    	];

        if (isset($req->id)) {
            $this->validate($req,[
                'description' => 'required|max:50',
            ]);

            $name = DropdownName::find($req->id);

            $name->description = $req->description;
            $name->update_user = Auth::user()->id;

            if ($name->update()) {
            	$data = [
		    		'msg' => 'Successfully updated.',
		    		'status' => 'success',
		    		'name' => $this->getName()
		    	];
            } else {
            	$data = [
		    		'msg' => 'No changes made.',
		    		'status' => 'success',
		    		'name' => $this->getName()
		    	];
            }

            $this->_userlog->log([
                'module' => 'Dropdown Settings',
                'action' => 'Updated Dropdown name '.$name->description,
                'user_id' => Auth::user()->id
            ]);
        } else {
            $this->validate($req,[
                'description' => 'required|unique:dropdown_names|max:50',
            ]);

            $name = new DropdownName;

            $name->description = $req->description;
            $name->create_user = Auth::user()->id;
            $name->update_user = Auth::user()->id;

            if ($name->save()) {
            	$data = [
		    		'msg' => 'Successfully updated.',
		    		'status' => 'success',
		    		'name' => $this->getName()
		    	];

                $this->_userlog->log([
                    'module' => 'Dropdown Settings',
                    'action' => 'Added Dropdown name '.$name->description,
                    'user_id' => Auth::user()->id
                ]);
            }
        }

        return response()->json($data);
    }

    public function save_option(Request $req)
    {
    	$data = [
    		'msg' => 'Saving failed.',
    		'status' => 'failed',
    		'option' => ''
    	];

        if (isset($req->option_id)) {
            $this->validate($req,[
                'option_description' => 'required|max:50',
            ]);

            $check = DropdownOption::where('dropdown_id',$req->dropdown_id)
                                    ->where('option_description',$req->option_description)
                                    ->count();

            if ($check > 1) {
                return response()->json(['errors' => ['option_description' => 'This option is already added.'] ], 422);
            } else {
                $option = DropdownOption::find($req->option_id);

                $option->option_description = $req->option_description;
                $option->update_user = Auth::user()->id;


                if ($option->update()) {
                    $data = [
                        'msg' => "Options was successfully updated.",
                        'status' => 'success',
                        'option' => $this->getOptions($req->dropdown_id)
                    ];

                    $this->_userlog->log([
                        'module' => 'Dropdown Settings',
                        'action' => 'Updated Dropdown option '.$option->option_description,
                        'user_id' => Auth::user()->id
                    ]);
                } else {
                    $data = [
                        'msg' => "No changes made.",
                        'status' => 'success',
                        'option' => $this->getOptions($req->dropdown_id)
                    ];
                }
            }

            return response()->json($data);
        } else {
            $this->validate($req,[
                'option_description' => 'required|max:50',
            ]);

            $check = DropdownOption::where('dropdown_id',$req->dropdown_id)
                                    ->where('option_description',$req->option_description)
                                    ->count();

            if ($check > 1) {
                return response()->json(['errors' => ['option_description' => 'This option is already added.'] ], 422);
            } else {
                $option = new DropdownOption;

                $option->dropdown_id = $req->dropdown_id;
                $option->option_description = $req->option_description;
                $option->create_user = Auth::user()->id;
                $option->update_user = Auth::user()->id;

                if ($option->save()) {
                    $data = [
                        'msg' => "Options was successfully added.",
                        'status' => 'success',
                        'option' => $this->getOptions($req->dropdown_id)
                    ];

                    $this->_userlog->log([
                        'module' => 'Dropdown Settings',
                        'action' => 'Added Dropdown option '.$option->option_description,
                        'user_id' => Auth::user()->id
                    ]);
                } else {
                    $data = [
                        'msg' => "Adding option failed.",
                        'status' => 'failed',
                        'option' => $this->getOptions($req->dropdown_id)
                    ];
                }
            }

            return response()->json($data);
        }
    }

    public function show_name()
    {
        $name = $this->getName();
        return response()->json($name);
    }

    public function show_option(Request $req)
    {
        $option = $this->getOptions($req->dropdown_id);
        return response()->json($option);
    }

    public function destroy_name(Request $req)
    {
        $name = DropdownName::find($req->id);
        $name->delete();

        $this->_userlog->log([
            'module' => 'Dropdown Settings',
            'action' => 'Deleted Dropdown name ID '.$req->id,
            'user_id' => Auth::user()->id
        ]);

        $name = DropdownName::orderBy('id','desc')->get();
        return response()->json($name);
    }

    public function destroy_option(Request $req)
    {
        $data = [
            'msg' => "Deleting failed",
            'status' => "failed",
            'option' => ''
        ];

        $ids = explode(',',$req->id);

        if (is_array($ids)) {

            $option = DropdownOption::whereIn('id',$ids)->delete();

            if ($option) {
                $data = [
                    'msg' => "Data was successfully deleted.",
                    'status' => "success",
                    'option' => $this->getOptions($req->dropdown_id)
                ];

                $ids = implode(',', $req->id);
                $this->_userlog->log([
                    'module' => 'Dropdown Settings',
                    'action' => 'Deleted Dropdown options ID '.$ids,
                    'user_id' => Auth::user()->id
                ]);
            }
                
        } else {
            $option = DropdownOption::find($req->id);
            $option->delete();

            $data = [
                'msg' => "Data was successfully deleted.",
                'status' => "success",
                'option' => $this->getOptions($req->dropdown_id)
            ];

            $this->_userlog->log([
                'module' => 'Dropdown Settings',
                'action' => 'Deleted Dropdown option ID '.$req->id,
                'user_id' => Auth::user()->id
            ]);
        }

        return response()->json($data);
    }

    private function getName()
    {
    	$name = DropdownName::orderBy('id','desc')->get();
        return $name;
    }

    private function getOptions($id)
    {
    	$option = DropdownOption::where('dropdown_id',$id)
        					->orderBy('id','desc')->get();
        return $option;
    }
}
