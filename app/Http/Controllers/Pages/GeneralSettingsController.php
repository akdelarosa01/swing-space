<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\UserLogsController;
use App\Incentive;
use App\Reward;
use App\Discount;

class GeneralSettingsController extends Controller
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
        if ($this->_global->checkAccess('GEN_SET')) {
            return view('pages.settings.general_settings',[
                'user_access' => $this->_global->UserAccess()
            ]);
        } else {
            return redirect('/dashboard');
        }
    }

    public function save_incentive(Request $req)
    {
        $data = [
            'msg' => 'Saving failed',
            'status' => 'failed',
            'incentives' => ''
        ];

        if (isset($req->inc_id)) {
            $this->validate($req,[
                'price_from' => 'required|regex:/^\d*(\.\d{1,2})?$/',
                'price_to' => 'required|regex:/^\d*(\.\d{1,2})?$/',
                'points' => 'required|numeric'
            ]);

            $incentive = Incentive::where('id',$req->inc_id)->update([
                            'price_from' => $req->price_from,
                            'price_to' => $req->price_to,
                            'points' => ($req->points == '' || $req->points == 0)? 0 : $req->points,
                            'update_user' => Auth::user()->id,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

            if ($incentive) {
                $this->_userlog->log([
                    'module' => 'General Settings',
                    'action' => 'Updated incentive setting Price from '.$req->price_from.' to '.$req->price_to.' equivalent to '.$req->points.' points.',
                    'user_id' => Auth::user()->id
                ]);

                $data = [
                    'msg' => 'Incentive settings successfully updated',
                    'status' => 'success',
                    'incentives' => $this->incentives()
                ];
            }
        } else {
            $this->validate($req,[
                'price_from' => 'required|regex:/^\d*(\.\d{1,2})?$/',
                'price_to' => 'required|regex:/^\d*(\.\d{1,2})?$/',
                'points' => 'required|numeric'
            ]);

            $incentive = Incentive::create([
                            'price_from' => $req->price_from,
                            'price_to' => $req->price_to,
                            'points' => ($req->points == '' || $req->points == 0)? 0 : $req->points,
                            'create_user' => Auth::user()->id,
                            'update_user' => Auth::user()->id,
                        ]);

            if ($incentive) {
                $this->_userlog->log([
                    'module' => 'General Settings',
                    'action' => 'Set incentive setting Price from '.$req->price_from.' to '.$req->price_to.' equivalent to '.$req->points.' points.',
                    'user_id' => Auth::user()->id
                ]);

                $data = [
                    'msg' => 'Incentive settings successfully saved',
                    'status' => 'success',
                    'incentives' => $this->incentives()
                ];
            }
        }

        return response()->json($data);
    }

    public function delete_incentive(Request $req)
    {
        $data = [
            'msg' => 'Deleting failed.',
            'status' => 'failed'
        ];

        $inc = Incentive::find($req->id);

        if ($inc->delete()) {
            $data = [
                'msg' => 'Successfully deleted.',
                'status' => 'success'
            ];
        }

        return response()->json($data);
    }

    public function incentives()
    {
        $inc = Incentive::all();
        return response()->json($inc);
    }

    public function save_reward(Request $req)
    {
        $data = [
            'msg' => 'Saving failed',
            'status' => 'failed',
            'rewards' => ''
        ];

        if (isset($req->rwd_id)) {
            $this->validate($req,[
                'deducted_price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
                'deducted_points' => 'required|numeric',
            ]);

            $rewards = Reward::where('id',$req->rwd_id)->update([
                            'deducted_price' => $req->deducted_price,
                            'deducted_points' => ($req->deducted_points == '' || $req->deducted_points == 0)? 0 : $req->deducted_points,
                            'update_user' => Auth::user()->id,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

            if ($rewards) {
                $this->_userlog->log([
                    'module' => 'General Settings',
                    'action' => 'Update Reward setting to deduct '.$req->deducted_price.' equivalent to '.$req->deducted_points.' points.',
                    'user_id' => Auth::user()->id
                ]);

                $data = [
                    'msg' => 'Reward settings successfully updated',
                    'status' => 'success',
                    'rewards' => $this->rewards()
                ];
            }
        } else {
            $this->validate($req,[
                'deducted_price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
                'deducted_points' => 'required|numeric',
            ]);

            $rewards = Reward::create([
                            'deducted_price' => $req->deducted_price,
                            'deducted_points' => ($req->deducted_points == '' || $req->deducted_points == 0)? 0 : $req->deducted_points,
                            'create_user' => Auth::user()->id,
                            'update_user' => Auth::user()->id,
                        ]);

            if ($rewards) {
                $this->_userlog->log([
                    'module' => 'General Settings',
                    'action' => 'Set Reward setting to deduct '.$req->deducted_price.' equivalent to '.$req->deducted_points.' points.',
                    'user_id' => Auth::user()->id
                ]);

                $data = [
                    'msg' => 'Reward settings successfully saved',
                    'status' => 'success',
                    'rewards' => $this->rewards()
                ];
            }
        }

        return response()->json($data);
    }

    public function delete_reward(Request $req)
    {
        $data = [
            'msg' => 'Deleting failed.',
            'status' => 'failed'
        ];

        $rwd = Reward::find($req->id);

        if ($rwd->delete()) {
            $data = [
                'msg' => 'Successfully deleted.',
                'status' => 'success'
            ];
        }

        return response()->json($data);
    }

    public function rewards()
    {
        $rwd = Reward::select(
                            'id',
                            'deducted_price',
                            'deducted_points'
                        )->first();
        return response()->json($rwd);
    }

    public function save_discount(Request $req)
    {
        $data = [
            'msg' => 'Saving failed',
            'status' => 'failed',
            'discounts' => ''
        ];

        if ($req->discount_id) {
            $this->validate($req,[
                'description' => 'required',
                'percentage' => 'required'
            ]);

            $dis = Discount::where('id',$req->discount_id)
                            ->update([
                                'description' => $req->description,
                                'percentage' => $req->percentage/100,
                                'update_user' => Auth::user()->id,
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);

            if ($dis) {
                $this->_userlog->log([
                    'module' => 'General Settings',
                    'action' => 'Updated discount setting '.$req->description,
                    'user_id' => Auth::user()->id
                ]);

                $data = [
                    'msg' => 'Discounts were uccessfully updated',
                    'status' => 'success',
                    'discounts' => ''
                ];
            }
        } else {
            $this->validate($req,[
                'description' => 'required',
                'percentage' => 'required'
            ]);

            $dis = Discount::create([
                        'description' => $req->description,
                        'percentage' => $req->percentage/100,
                        'create_user' => Auth::user()->id,
                        'update_user' => Auth::user()->id
                    ]);

            if ($dis) {
                $this->_userlog->log([
                    'module' => 'General Settings',
                    'action' => 'Added discount setting '.$req->description,
                    'user_id' => Auth::user()->id
                ]);

                $data = [
                    'msg' => 'Discounts were uccessfully saved',
                    'status' => 'success',
                    'discounts' => ''
                ];
            }
        }

        return response()->json($data);
    }

    public function delete_discount(Request $req)
    {
        $data = [
            'msg' => 'Deleting failed.',
            'status' => 'failed'
        ];

        $dis = Discount::find($req->id);

        if ($dis->delete()) {
            $data = [
                'msg' => 'Successfully deleted.',
                'status' => 'success'
            ];
        }

        return response()->json($data);
    }

    public function discounts()
    {
        $dis = Discount::all();
        return response()->json($dis);
    }
}
