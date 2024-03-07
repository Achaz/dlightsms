<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

class bcastqueueCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bcastqueue:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //process queued messages
        $sql2 = DB::select("SELECT * FROM bcast_queue WHERE processing = 1 and sent = 0");
	    //$res2 = db_query($sql2) or die('failed to get the list');
        //$count_num = count($sql)
        if (count($sql2) >= 1) {     // we have some messages in the queue so don't resend 

            \Log::info("messages in the queue so hold");
                // sleep(10);
        } else {
            // get the details from the ost_bcast_table and run it by sendmsg2list function
            $sql = DB::select("SELECT * FROM bcast_queue WHERE sent = 0 AND processing = 0 LIMIT 1");
   
            //$res = db_query($sql) or die('failed to get the list');
            //$sent = 0;
            $job_id = '';
            $senderid = '';
            $msg  = '';
            $list_id = '';
            $userid = '';
            $sent = '';
            $title = '';
            $network = '';
            
            for ($i=0; $i<=count($sql); $i++) {
                
                try {
                    // set the queue to pending
                    DB::update("UPDATE bcast_queue SET sent = '0', processing = '1' WHERE q_id = ".$sql[$i]->q_id."");
                            
                    $userid   = $sql[$i]->user_id; 
                    $senderid = $sql[$i]->sender_id;
                    $list_id  = $sql[$i]->list_id; 
                    $msg      = $sql[$i]->msg;
                    $title    = $sql[$i]->title;
                    $network  = $sql[$i]->network;
                    $job_id   = $sql[$i]->job_id;  // that we shall use for some reports
                        
                    $sms = $this->sendmsg2list($userid,$senderid,$list_id,$msg,$network,$title,$job_id);
                    
                    // update the bcast_queue afterwards.		
                    DB::update("UPDATE bcast_queue SET sent = '1', processing = '1' WHERE q_id = ".$sql[$i]->q_id."");

                }catch(\Exception $e) {

                    \Log::error($e->getMessage());

                }


            }


         }
    }

    public function sendmsg2list($userid,$senderid,$list_id,$msg,$network,$title,$job_id) { 
	
        $sql = DB::select("SELECT n.msisdn FROM bcast_list_maps m, bcastlists l, bcast_numbers n WHERE m.num_id = n.id AND l.id = m.list_id and m.list_id =".$list_id."");
        
        \Log::info($sql);

        if (collect($sql)->first()) { 

            $count_num = count($sql);

            \Log::info("numbers count:".$count_num);

            $creditcheck = $this->check2credit($userid,$count_num);

            if ($creditcheck == "true") {

                \Log::info("You don't have enough credit.  Please try again");

            }else{
                // initialize the counter
                $countn = 0;

                for ($i=0; $i<=count($sql); $i++) {

                    try {

                        $msisdn = $sql[$i]->msisdn;
                        \Log::info("MSISDN:".$msisdn);
                        $sendsms = $this->send2sms($senderid,$msisdn,$msg,$userid);
                        $countn = $countn + 1;

                    }catch(\Exception $e) {

                        \Log::error($e->getMessage());

                    }
                }
                
                // deduct the credit
                $dc = $this->deduct2credit($userid,$countn);
                // update the list
                DB::update('update bcastlists set  last_sent = CURRENT_TIMESTAMP WHERE id  = ?',[$list_id]);

                DB::table('bill_logs')->insert([                  
                    'list_id' => $list_id,
                    'user_id' => $userid,
                    'sender_id' => $senderid,
                    'msg' => $msg,
                    'job_id' => $job_id,
                    'units' => $countn,
                    'ts_stamp' => \Carbon\Carbon::now()->toDateTimeString()
                ]);

                \Log::info("Bulk SMS has been successfully sent"); 
                
            }
         

         } else {
        
            \Log::info("No numbers to send message to. Please try again");

        }

    }
    function random_strings($length_of_string)
    {
 
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    
        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result),0, $length_of_string);
    }

    public function send2sms($dest,$sender,$msg,$userid) {

        $sender = trim($sender);
        $sender = intval($sender);
        
        $str = substr($sender,0,-7);
        $msg = urlencode($msg);
    
        $dest = urlencode($dest);
    
        $dlrmask = 31;
        $dest = "8177";

        $ran_number = $this->randomAlphaNum(12);
         
        $dlrurl = "https://dlightsms.qed.co.ug/api_dlr?";

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
        
        \Log::info($cmd);
 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$cmd);
        curl_exec($ch);
        curl_close($ch);
    }

    public function check2credit($user_id,$count_num) {
        // check if you have enough credit before we deduct credit 
        $sql =DB::select("SELECT units FROM sms_credits WHERE user_id = '.$user_id.'");

        //$units = 0;
        for ($i=0; $i<=count($sql); $i++) {

            try {

                $units = $sql[$i]->units;

                \Log::info("units:".$units);
                
                \Log::info("count_num:".$count_num);

                if ($units < $count_num){
                    return false;
                }else{
                    return true;
                }
                    

            }catch(\Exception $e) {

                \Log::error($e->getMessage());

            }

        }
        
        
    }
    
    public function deduct2credit($user_id,$count_num) {
        // if all is ok. Now you can deduct the credit
        DB::update('UPDATE sms_credits SET units = units - '.$count_num.' WHERE user_id  = ?',[$user_id]);
        // echo $d_sql;
        //$d_res = db_query($d_sql) or die('failed to deduct credits');
        \Log::info("Successfully deducted credits");
    }
}
