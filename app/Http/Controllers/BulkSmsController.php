<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Bill_log;
use App\Models\SmsCredit;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Jobs\SendBulkSms;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;

class BulkSmsController extends Controller
{
    public function index() 
    {
       $names=Auth::user()->name;

        $id = Auth::user()->id; 
        // get data
        // staff with r/s list
        // $list
        //$bulkdeliveryreports = \App\Models\BulkDeliveryReports::all();

        $messages = \App\Models\Message::with('User')->get();

        $lists = \App\Models\Bcastlist::all();

        $networks = \App\Models\Network::all();
        //($lists->toArray());
        //return view('broadcasts.bulksms', compact('bulkdeliveryreports'));


         return view('broadcasts.bulksms')->with('messages',$messages)->with('lists', $lists)->with('networks',$networks)->with('names',$names);
        //$list->name
    }

    public function sendbulksms(Request $request)
    {
        //$bill_log = new Bill_log();
        $id = Auth::user()->id; 

        $ts_stamp = \Carbon\Carbon::now()->toDateTimeString();

        $list_id=$request->list_id;
        $msg=$request->message;
        $title=$request->title;
        $senderid=$request->senderid;
        $network=$request->network;
    
        $rand_job_id = date('is');
        $job_id = $id.$list_id.$rand_job_id;

        $response = $this->sendmsg2list($id,$senderid,$list_id,$msg,$network,$title,$job_id);

        return redirect('/bulksms')->with('status', $response);

    }

    // get the count of messages.
    function getCount($msg) {

        $len = strlen($msg);
        $num = ceil($len / 159);
        return $num;

    }

    function sendsms($sender,$dest,$msg) {

        $url = "http://localhost:13013/cgi-bin/sendsms?from=".$dest."&to=".$sender."&username=smsadmin";
        $url .= "&password=smsadmin123&smsc=smsc3&text=".$msg."&coding=0";
        $cmd = "lynx -dump '$url'";
        
        shell_exec($cmd);
    }



    // log all sent SMS very important...
    function log2sms($msisdn,$senderid,$msg,$list_id,$userid,$job_id) {
        // $sql = "INSERT INTO sent_sms (sender, dest,message,list_id,job_id,user_id) 
        //     VALUES(".db_input($msisdn).",".$senderid.",".$msg.",".$list_id.",".$job_id.",".$userid.")";

        DB::table('sent_sms')->insert([
            'sender' => $msisdn,
            'dest' => $senderid,
            'message' => $msg,
            'list_id' => $list_id,
            'job_id' => $job_id,
            'user_id' => $userid
            
        ]);
       
    }

    // function for queueing messages
    function queue_sms($senderid,$msg,$user_id,$list_id,$network,$title,$job_id) 
    {

    // $sql = "INSERT INTO ".BCAST_QUEUE."(sender_id,msg,ts_stamp,user_id,list_id,network,title,job_id) VALUES (".db_input($senderid).",".db_input($msg).",
    //     CURRENT_TIMESTAMP,".db_input($user_id).",".db_input($list_id).",".db_input($network).",".db_input($title).",".db_input($job_id).")";
    //     // echo $sql;
    // $res = db_query($sql) or die("failed to insert bcast_queue");
    // if ($res) 
    //     return "Your sms has been queued for delivery. Wait for a few minutes for it to be processed.";
    // else
    //     return "An error has occurred. Please try again";	

    }

    function get_smsroute($userid) {
        // $sql = "SELECT route_name FROM ".SMSROUTE_TABLE." WHERE staff_id = ".db_input($userid);
        // // echo $sql;	
        // $res = db_query($sql) or die('failed to execute route'.$sql);
        // $arr = db_fetch_array($res);
        // return $arr['route_name'];
    }

    function sent_sms($senderid,$msg,$user_id,$list_id,$network,$title,$job_id) {

        // $sql = "INSERT INTO ".BCAST_QUEUE."(sender_id,msg,ts_stamp,user_id,list_id,network,title,job_id,sent,processing) VALUES (".db_input($senderid).",".db_input($msg).",
        //         CURRENT_TIMESTAMP,".db_input($user_id).",".db_input($list_id).",".db_input($network).",".db_input($title).",".db_input($job_id).",1,1)";
        //   // echo $sql;
        // $res = db_query($sql) or die("failed to insert bcast_queue");
    }

    function send2sms_route($dest,$sender,$msg,$userid,$msg_id) {

		
        // what if you have more than one link we can send out using separate connections.
        $sender = trim($sender);
        $sender = intval($sender);
        
        $str = substr($sender,0,-7);
        $msg = urlencode($msg);
    
        $dest = urlencode($dest);
    
        $dlrmask = 31;
            $dest = "8177";
    
            // $ran_number = randomAlphaNum(12);
    
        
        $dlrurl = "http://130.61.21.213/sms/dlr.php?";
        // $q_str = "log_no=$ran_number&message=$msg&user_id=$userid&senderid=$dest&phonenum=%p&smscid=%i&ts_stamp=%t&dlrvalue=%d&smsid=%I";
        //     $str_url = urlencode($q_str);
        
        // $dlrurl = $dlrurl.$str_url;
    
    
        switch($str) {
            case '25678':
            case '25677':
            case '25676':
                $cmd = 'http://localhost:13013/cgi-bin/sendsms?coding=0&username=smsadmin&password=smsadmin123&smsc=SMSC01&from='.$dest.'&to='.$sender.'&text='.$msg;
                break;
             case '25675':
             case '25670':
                $dest = '8177';
                            $cmd = 'http://localhost:13013/cgi-bin/sendsms?coding=0&username=smsadmin&password=smsadmin123&smsc=SMSC01&from='.$dest.'&to='.$sender.'&text='.$msg;
                break; 
            default:
                $dest ='8177';
                $cmd = 'http://localhost:13013/cgi-bin/sendsms?coding=0&username=smsadmin&password=smsadmin123&smsc=SMSC01&from='.$dest.'&to='.$sender.'&text='.$msg;
        }		
    
        $cmd = $cmd.'&dlr-mask=31&dlr-url='.$dlrurl;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$cmd);
        curl_exec($ch);
        curl_close($ch);
    }

    function sendmsg2list($userid,$senderid,$list_id,$msg,$network,$title,$job_id) { 

        $numbers = DB::select("SELECT n.msisdn,n.field1, n.field2, n.field3,n.field4,n.field5, n.field6 FROM bcast_list_maps m, bcastlists l, bcast_numbers n 
        WHERE m.num_id = n.id AND l.id = m.list_id and m.list_id =".$list_id." AND n.msisdn regexp '^".$network."'");

        $ts_stamp = \Carbon\Carbon::now()->toDateTimeString();
        $count_num = count($numbers);
        $no_of_msgs = $this->getCount($msg);
        $total_count = $count_num * $no_of_msgs;

        $final_msg = "";
        $draftsms=[];
       
        if (!$this->check2credit($userid,$total_count)) {
     
            return "You don't have enough credit.  Please load credit";

            Log::info("You don't have enough credit.  Please load credit");

        }else{

            for ($i=0; $i<=count($numbers); $i++) {
                //$colours[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
                try {
                    $msg1 = str_replace('#Name',$numbers[$i]->field1,$msg);
                    $msg2 = str_replace('#Account', $numbers[$i]->field2, $msg1);
                    $msg3 = str_replace('#Amount', $numbers[$i]->field3, $msg2);
                    $msg4 = str_replace('#Reward', $numbers[$i]->field4, $msg3);
                    $msg5 = str_replace('#Token', $numbers[$i]->field5, $msg4);
                    $msg6 = str_replace('#Days',$numbers[$i]->field6, $msg5);
                    $final_msg = $msg6;

                    $this->log2sms($numbers[$i]->msisdn,$senderid,$final_msg,$list_id,$userid,$job_id);
                    // $count = $count + 1;

                    // write to the file from here and then send the SMS once out of the loop. 
                    $draftsms[] = $numbers[$i]->msisdn."|".$senderid."|".$final_msg."|".$list_id."|".$userid."|".$job_id."\n";
            
                    
                } catch (\Throwable $th) {
                    //throw $th;
                    logger($th);
                }
            

            }

            // deduct the credit
            $dc = $this->deduct2credit($userid,$total_count);
       
            $ts_stamp = \Carbon\Carbon::now()->toDateTimeString();

            $file = "numbers".$ts_stamp;
            Storage::put($file.".txt", implode("\n",$draftsms));
            $file_path = storage_path("app/".$file.".txt");
               
            SendBulkSms::dispatch($file_path);

            DB::table('bcast_queue')->insert([
                'sender_id' => $senderid,
                'msg' => $final_msg,
                'list_id' => $list_id,
                'network' => $network,
                'user_id' => Auth::id(),
                'job_id' => $job_id,
                'title' => $title,
                'ts_stamp' => \Carbon\Carbon::now()->toDateTimeString(),
                'sent' => '1',
                'processing' =>'1'
            ]);
                      
            DB::table('bill_logs')->insert([
                'units' => $total_count,
                'user_id' => $userid,
                'list_id' => $list_id,
                'sender_id' => $senderid,
                'msg' => $msg,
                'job_id' => $job_id,
                'ts_stamp' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
            
            $count = 0;
        
            $msg1 = "";
            $msg2 = "";
            $msg3 = "";
            $msg4 = "";
            $msg5 = "";
            $msg6 = "";
    
            DB::update('update bcastlists set last_sent = ? where created_by = ?',[$ts_stamp,$userid]);
    

            return "Bulk SMS has been successfully sent";

        }

    }

    public function deduct2credit($user_id,$count_num) {
        // if all is ok. Now you can deduct the credit
        DB::update('UPDATE sms_credits SET units = units - '.$count_num.' WHERE user_id  = ?',[$user_id]);
        // echo $d_sql;
        //$d_res = db_query($d_sql) or die('failed to deduct credits');
        Log::info("Successfully deducted credits");
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
