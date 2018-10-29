<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\DropdownName;
use App\DropdownOption;

class DropdownController extends Controller
{
    protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }

    public function index()
    {
        return view('pages.settings.dropdown',['user_access' => $this->_global->UserAccess()]);
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

        if (isset($req->id)) {
            $this->validate($req,[
                'option_description' => 'required|max:50',
            ]);

            $name = DropdownOption::where('dropdown_id',$req->dropdown_id)
            						->delete();

            $option = [];

           	foreach ($req->ids as $key => $id) {
           		array_push($option,[
           			'dropdown_id' => $req->dropdown_id,
           			'description' => $req->option_description,
           			'create_user' => Auth::user()->id,
           			'update_user' => Auth::user()->id,
           		]);
           	}
            
            $inserts = array_chunk($option, 1000);
            foreach ($inserts as $batch) {
                DropdownOption::insert($batch);
                $data = [
                    'msg' => "Options was successfully updated.",
                    'status' => 'success',
                    'option' => $this->getOption($req->dropdown_id)
                ];
            }

            return response()->json($data);
        } else {
            $this->validate($req,[
                'description' => 'required|max:50',
            ]);

            $option = [];

           	foreach ($req->ids as $key => $id) {
           		array_push($option,[
           			'dropdown_id' => $req->dropdown_id,
           			'description' => $req->option_description,
           			'create_user' => Auth::user()->id,
           			'update_user' => Auth::user()->id,
           		]);
           	}
            
            $inserts = array_chunk($option, 1000);
            foreach ($inserts as $batch) {
                DropdownOption::insert($batch);
                $data = [
                    'msg' => "Options was successfully saved.",
                    'status' => 'success',
                    'option' => $this->getOption($req->dropdown_id)
                ];
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
        $option = $this->getOptions($req->id);
        return response()->json($option);
    }

    public function destroy_name(Request $req)
    {
        $name = DropdownName::find($req->id);
        $name->delete();

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

        if (is_array($req->ids)) {
            foreach ($req->ids as $key => $id) {
                $option = DropdownOption::find($id);
                $option->delete();

                $data = [
                    'msg' => "Data was successfully deleted.",
                    'status' => "success",
                    'option' => $this->getOption($req->dropdown_id)
                ];
            }
        } else {
            $option = DropdownOption::find($req->ids);
            $option->delete();

            $data = [
                'msg' => "Data was successfully deleted.",
                'status' => "success",
                'option' => $this->getOption($req->dropdown_id)
            ];
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
