<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\UserLogsController;
use Carbon\Carbon;
use Zipper;
use Excel;
use File;
use Mail;
use DB;

class SendReportsController extends Controller
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
        if ($this->_global->checkAccess('SND_RPT')) {
            return view('pages.reports.send_reports',[
                'user_access' => $this->_global->UserAccess()
            ]);
        } else {
            return redirect('/dashboard');
        }
    }

    public function save(Request $req)
    {
    	$filenames = [];
    	$dbPath = 'reports/';
        $destinationPath = storage_path($dbPath);

        $data = [
        	'msg' => 'Sending failed.',
        	'status' => 'failed'
        ];

        $this->validate($req,[
            'email_to' => 'required',
            'email_subject' => 'required'
        ]);

    	if (isset($req->attachment)) {
            foreach ($req->attachment as $key => $attachment) {
            	$fileName = $attachment->getClientOriginalName();//.'.'.$attachment->getClientOriginalExtension();

            	array_push($filenames, $attachment->getClientOriginalName());

	            if (!File::exists($destinationPath)) {
	                File::makeDirectory($destinationPath, 0777, true, true);
	            }

	            if (File::exists($destinationPath.'/'.$fileName)) {
	                File::delete($destinationPath.'/'.$fileName);
	            }

	            $attachment->move($destinationPath, $fileName);
            }
        }

        $pathToFile = $destinationPath.'/Reports_'.date('Y-m-d').'.zip';

        $files = glob($destinationPath.'/*');
		Zipper::make($pathToFile)->add($files)->close();

        $details = [
            'email_from' => Auth::user()->email,
            'email_msg' => $req->email_msg
        ];

		$sent = Mail::send('email.reports', $details, function ($mail) use ($req,$pathToFile) {
		                $mail->to($req->email_to)
		                    ->from(Auth::user()->email,'Swing Space: '.Auth::user()->firstname.' '.Auth::user()->lastname)
		                    ->subject($req->email_subject);
		                $mail->attach($pathToFile);
		            });

		// if ($sent) {
            foreach ($filenames as $key => $file) {
                if (File::exists($destinationPath.'/'.$file)) {
                    File::delete($destinationPath.'/'.$file);
                }
            }

            if (File::exists($pathToFile)) {
                File::delete($pathToFile);
            }
			
			$data = [
	        	'msg' => 'Email successfully sent.',
	        	'status' => 'success'
	        ];
		// }

		return response()->json($data);
    }
}
