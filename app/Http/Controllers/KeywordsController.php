<?php

namespace App\Http\Controllers;

use App\Models\Keywords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToArray;

class KeywordsController extends Controller
{
    public function index(Request $request){


        return view('broadcasts.keywordslists', [
            'keywords' => \App\Models\Keywords::paginate(5)
        ]);

    }

    public function create(){

         return view('broadcasts.keywords');

    }

    public function edit(Keywords $keyword){

        //dd($keyword);
        return view('broadcasts.editkeyword', [
            'keyword' => $keyword
        ]);

    }

    public function update(Request $request, Keywords $keyword){

        $keywd_id =  $keyword->id;

        $keywords = Keywords::where('id', $keywd_id)->first();

        try {

            DB::beginTransaction();

            $keywords->update([
                    'keywd' => $request->input('keywd'),
                    'keywd_alias' => $request->input('keywd_alias'),
                    'response' => $request->input('response'),
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);

            DB::commit();

        }catch (\Throwable $th) {

            DB::rollBack();

            return back()->with('error', $th->getMessage());
        }
        return redirect()
            ->route('broadcasts.keywords')
            ->with('status','Keyword updated successfully');

    }

    public function delete($id){

        DB::table('keywords')->where('id', $id)->delete();

        return redirect('/keywords')->with('status', 'Keyword Deleted');
    }

    function random_strings($length_of_string)
    {
 
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    
        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result),0, $length_of_string);
    }

    public function receivesms(Request $request)
    {

        $sender = Request::createFromGlobals()->get('sender');
        $keyword = Request::createFromGlobals()->get('keyword');
        $handler = Request::createFromGlobals()->get('handler');
        $ts_stamp = Request::createFromGlobals()->get('ts_stamp');
        $dest =Request::createFromGlobals()->get('dest');
        $charset = Request::createFromGlobals()->get('charset');
        $msgid = Request::createFromGlobals()->get('msgid');
        $sms_id = rand(000001,999999);
        DB::table('keywordlogs')->insert([
            'sender' => $sender,
            'keywd' => $keyword,
            'request' => strip_tags($handler),
            'ts_stamp' => $ts_stamp,
            'msgid' => $msgid,
            'dest' => $dest,
            'sms_id' => $sms_id,
            'created' => \Carbon\Carbon::now()->toDateTimeString(),
            'charset'  => $charset           
        ]);

        Log::info("MO successfully received");

        $response = $this->getResponse($keyword);

        $msg_id = $this->random_strings(12);

        $staff_id= 1;
        //($dest,$sender,$msg,$user_id,$msgid)
        $this->send2sms_route($dest,$sender,$response,$staff_id,$msg_id); // send response back to the subscriber/sender

    }

    public function send2sms_route($dest,$sender,$msg,$user_id,$msgid) {

        // what if you have more than one link we can send out using separate connections.
        $sender = trim($sender);
        $sender = intval($sender);
        
        $str = substr($sender,0,-7);
        $msg = urlencode($msg);
    
        $dest = urlencode($dest);
    
        $dlrmask = 31;
        //$dest = "8177";
        $staff_id= $user_id;
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

        return 1;
    }

    public function storekeyword(Request $request){

        Keywords::create([
            'keywd' => $request->keywd,
            'keywd_alias' => $request->keywd_alias,
            'response' => $request -> response,
            'created_by' => Auth::user()->name,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()          
        ]);
   
        return redirect('/keywords')->with('status', 'Keyword Has Been Created');

    }

    public function getResponse($keywd){
        // if there is a function to process it, call that function
        //$skeywd = strtolower($keywd);
   
        $sqlb = DB::select("SELECT response FROM keywords WHERE keywd = '$keywd'");

        if(collect($sqlb)->first()){

            for ($i=0; $i<=count($sqlb); $i++) {

                try {

                    $resp = $sqlb[$i]->response;
                    //dd($resp);
                } catch (\Throwable $th) {
                    //throw $th;
                    logger($th);
                }

            } 
                 
            return $resp;  

        }else{

            return $resp = "Thank you for the message.We've logged your request.";
        }
        
    }

}
