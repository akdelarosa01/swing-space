<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\UserLog;
use DB;
use App\Events\UserLogs;

class UserLogsController extends Controller
{
    protected $_global;

    public function __construct()
    {
        $this->_global = new GlobalController;
    }

    public function index()
    {
        return view('super_admin.user_logs',[
                'user_access' => $this->_global->UserAccess()
            ]);
    }

    public function log(array $params)
    {
        UserLog::create($params);
        event(new UserLogs($params));
    }

    public function getLogs()
    {
        $logs = DB::table('user_logs as l')
                    ->join('users as u','u.id','=','l.user_id')
                    ->select(
                        DB::raw('l.id as id'),
                        DB::raw('l.module as module'),
                        DB::raw('l.action as action'),
                        DB::raw("concat(u.firstname,' ',u.lastname) as user_name"),
                        DB::raw("date_format(l.created_at,'%b. %d, %Y') as log_date")
                    )
                    ->orderBy('l.id','desc')->get();
        return response()->json($logs);
    }
}
