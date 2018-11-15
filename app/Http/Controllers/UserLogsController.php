<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\UserLog;
use App\Events\UserLogs;

class UserLogsController extends Controller
{
    protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }

    public function log(array $params)
    {
    	UserLog::create($params);
    	event(new UserLogs($params));
    }

    public function getLogs()
    {
        $logs = UserLog::orderBy('id','desc')->get();
        return response()->json($logs);
    }
}
