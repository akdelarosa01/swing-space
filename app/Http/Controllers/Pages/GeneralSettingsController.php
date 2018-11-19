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
                'inc_name' => 'required',
                'inc_points' => 'required',
                'inc_hrs' => 'required',
                'inc_days' => 'required',
                'inc_space' => 'required'
            ]);

            $incentive = Incentive::where('id',$req->inc_id)->update([
                            'inc_name' => $req->inc_name,
                            'inc_points' => ($req->inc_points == '' || $req->inc_points == 0)? 0 : $req->inc_points,
                            'inc_hrs' => ($req->inc_hrs == '' || $req->inc_hrs == 0)? 0 : $req->inc_hrs,
                            'inc_days' => ($req->inc_days == '' || $req->inc_days == 0)? 0 : $req->inc_days,
                            'inc_space' => $req->inc_space,
                            'inc_description' => $req->inc_description,
                            'update_user' => Auth::user()->id,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

            if ($incentive) {
                $this->_userlog->log([
                    'module' => 'General Settings',
                    'action' => 'Updated incentive setting '.$req->inc_name,
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
                'inc_name' => 'required',
                'inc_points' => 'required',
                'inc_hrs' => 'required',
                'inc_days' => 'required',
                'inc_space' => 'required'
            ]);

            $incentive = Incentive::create([
                            'inc_code' => $this->_global->TransactionNo('INC_CODE'),
                            'inc_name' => $req->inc_name,
                            'inc_points' => ($req->inc_points == '' || $req->inc_points == 0)? 0 : $req->inc_points,
                            'inc_hrs' => ($req->inc_hrs == '' || $req->inc_hrs == 0)? 0 : $req->inc_hrs,
                            'inc_days' => ($req->inc_days == '' || $req->inc_days == 0)? 0 : $req->inc_days,
                            'inc_space' => $req->inc_space,
                            'inc_description' => $req->inc_description,
                            'create_user' => Auth::user()->id,
                            'update_user' => Auth::user()->id,
                        ]);

            if ($incentive) {
                $this->_userlog->log([
                    'module' => 'General Settings',
                    'action' => 'Added incentive setting '.$req->inc_name,
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
                'rwd_name' => 'required',
                'rwd_points' => 'required',
                'rwd_hrs' => 'required',
                'rwd_days' => 'required',
                'rwd_space' => 'required'
            ]);

            $rewards = Reward::where('id',$req->rwd_id)->update([
                            'rwd_name' => $req->rwd_name,
                            'rwd_points' => ($req->rwd_points == '' || $req->rwd_points == 0)? 0 : $req->rwd_points,
                            'rwd_hrs' => ($req->rwd_hrs == '' || $req->rwd_hrs == 0)? 0 : $req->rwd_hrs,
                            'rwd_days' => ($req->rwd_days == '' || $req->rwd_days == 0)? 0 : $req->rwd_days,
                            'rwd_space' => $req->rwd_space,
                            'rwd_description' => $req->rwd_description,
                            'update_user' => Auth::user()->id,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

            if ($rewards) {
                $this->_userlog->log([
                    'module' => 'General Settings',
                    'action' => 'Updated reward setting '.$req->rwd_name,
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
                'rwd_name' => 'required',
                'rwd_points' => 'required',
                'rwd_hrs' => 'required',
                'rwd_days' => 'required',
                'rwd_space' => 'required'
            ]);

            $rewards = Reward::create([
                            'rwd_code' => $this->_global->TransactionNo('RWD_CODE'),
                            'rwd_name' => $req->rwd_name,
                            'rwd_points' => ($req->rwd_points == '' || $req->rwd_points == 0)? 0 : $req->rwd_points,
                            'rwd_hrs' => ($req->rwd_hrs == '' || $req->rwd_hrs == 0)? 0 : $req->rwd_hrs,
                            'rwd_days' => ($req->rwd_days == '' || $req->rwd_days == 0)? 0 : $req->rwd_days,
                            'rwd_space' => $req->rwd_space,
                            'rwd_description' => $req->rwd_description,
                            'create_user' => Auth::user()->id,
                            'update_user' => Auth::user()->id,
                        ]);

            if ($rewards) {
                $this->_userlog->log([
                    'module' => 'General Settings',
                    'action' => 'Added reward setting '.$req->rwd_name,
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

    public function rewards()
    {
        $rwd = Reward::all();
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

    public function discounts()
    {
        $dis = Discount::all();
        return response()->json($dis);
    }
}
