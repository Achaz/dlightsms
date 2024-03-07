<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bill_log;
use Illuminate\Support\Facades\DB;
use App\Models\SmsCredit;
use Illuminate\Support\Facades\Log;

class SingleSmsController extends Controller
{
    public function index() 
    {
        
        $routes = \App\Models\SmsRoutes::all();
        
        return view('broadcasts.singlesms')->with('routes',$routes);
        
    }

    function random_strings($length_of_string)
    {
 
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    
        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result),0, $length_of_string);
    }

    public function sendsinglesms(Request $request)
    {

        $bill_log = new Bill_log();
        $id = Auth::user()->id; 

        $list_id = 1;
        $nums = $_POST['phone'];
    	$arr_nums = explode(",",$nums);

        $rand_job_id = date('is');
        $job_id = $id.$list_id.$rand_job_id;

        $route_name = $request->route_name;

        $nums = $request->phone;
    	$arr_nums = explode(",",$nums);
        $count_num = sizeof($arr_nums);

        if (!$this->check2credit($id,$count_num)) {

            return redirect('/singlesms')->with('status', 'You do not have enough credit. Please load credit');

            Log::info("You don't have enough credit. Please load credit");

        }else{

            foreach($arr_nums as $key => $value) {
                
                $msg_id = $this->random_strings(12);
                
                $sms = $this->send2sms_route($request->senderid,$value,$request->message,Auth::user()->id,$msg_id);	
            }
            
            $bill_log->msg = $request->message;
            $bill_log->list_id = $list_id;
            $bill_log->job_id = $job_id;
            $bill_log->user_id = $id;
            $bill_log->sender_id = $request->senderid;
            $bill_log->units=$count_num;
            $bill_log->ts_stamp=\Carbon\Carbon::now()->toDateTimeString();
        
            $bill_log->save();

            DB::update('update sms_credits SET units = units - ? where user_id = ?',[$count_num,$id]);
    
            return redirect('/singlesms')->with('status', 'SMS have been sent');

       }


    }

    function send2sms_route($dest,$sender,$msg,$userid,$msg_id) 
    {	
        // what if you have more than one link we can send out using separate connections.
        $sender = trim($sender);
        $sender = intval($sender);
        
        $str = substr($sender,0,-7);
        $msg = urlencode($msg);
        $staff_id = $userid;
        $dest = urlencode($dest);
    
        $dlrmask = 31;
        $dest = "8177";

        $ran_number = $this->random_strings(12);
         
        $dlrurl = "https://dlightsms.qed.co.ug/dlr?";

        $q_str = "log_no=$ran_number&message=$msg&user_id=$staff_id&senderid=$dest&phonenum=%p&smscid=%i&ts_stamp=%t&dlrvalue=%d&smsid=%I";
       
        $str_url = urlencode($q_str);
        
        $dlrurl = $dlrurl.$str_url;
    
        switch($str) {
            case '25678':
                $dest ='8177';
                $cmd = 'http://localhost:13013/cgi-bin/sendsms?coding=0&smsc=SMSC02&to='.$sender.'&from='.$dest.'&text='.$msg.'&username=smsadmin&password=smsadmin123';
                break;
            case '25677':
                $dest ='8177';
                $cmd = 'http://localhost:13013/cgi-bin/sendsms?coding=0&smsc=SMSC02&to='.$sender.'&from='.$dest.'&text='.$msg.'&username=smsadmin&password=smsadmin123';
                break;
            case '25676':
                $dest ='8177';
                $cmd = 'http://localhost:13013/cgi-bin/sendsms?coding=0&smsc=SMSC02&to='.$sender.'&from='.$dest.'&text='.$msg.'&username=smsadmin&password=smsadmin123';
                break;
             case '25675':
                $dest = '8177';
                $cmd = 'http://localhost:13013/cgi-bin/sendsms?coding=0&smsc=SMSC03&to='.$sender.'&from='.$dest.'&text='.$msg.'&username=smsadmin&password=smsadmin123';
                break;
             case '25674':
                $dest = '8177';
                $cmd = 'http://localhost:13013/cgi-bin/sendsms?coding=0&smsc=SMSC03&to='.$sender.'&from='.$dest.'&text='.$msg.'&username=smsadmin&password=smsadmin123';
                break;
             case '25670':
                $dest = '8177';    
                $cmd = 'http://localhost:13013/cgi-bin/sendsms?coding=0&smsc=SMSC03&to='.$sender.'&from='.$dest.'&text='.$msg.'&username=smsadmin&password=smsadmin123';
                break; 
            default:
                $dest ='8177';
                $cmd = 'http://localhost:13013/cgi-bin/sendsms?coding=0&smsc=SMSC02&to='.$sender.'&from='.$dest.'&text='.$msg.'&username=smsadmin&password=smsadmin123';
        }		
    
        $cmd = $cmd.'&dlr-mask=31&dlr-url='.$dlrurl;
        
        Log::info($cmd);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$cmd);
        curl_exec($ch);
        curl_close($ch);
    }


    public function check2credit($user_id,$count_num) {

        // check if you have enough credit before we deduct credit 
        $sms_credit = SmsCredit::whereUser_id($user_id)->first();

        if ($sms_credit) {
            return $sms_credit->units>$count_num;
        }
        return false;

    }

    

}
