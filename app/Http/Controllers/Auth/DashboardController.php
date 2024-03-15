<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SmsCredit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {

        $colourms=$colours=$colours_api_mtn=$colours_api_airtel=[];

        $reports = $this->sms_logs();

        $units = $this->sms_units(Auth::id());

        $lists = $this->num_lists();

        return view('auth.dashboard',compact('reports','units','lists'));
    }

    public function user_charts(){

        $chart = DB::select("SELECT CONCAT(DATE_FORMAT(ts_stamp,'%b'),' ',YEAR(ts_stamp)) as month,count(phonenum) AS total FROM ost_dlr_reports WHERE YEAR(ts_stamp) = YEAR(CURDATE()) AND phonenum REGEXP '^2567[0|5|4]' group by month ORDER BY month ASC");
        $mtn =DB::select("SELECT CONCAT(DATE_FORMAT(ts_stamp,'%b'),' ',YEAR(ts_stamp)) as month,count(phonenum) AS total FROM ost_dlr_reports WHERE  YEAR(ts_stamp) = YEAR(CURDATE()) AND phonenum REGEXP '^2567[7|8|6]' group by month ORDER BY month ASC");

        $colourms=$colours=$colours_api_mtn=$colours_api_airtel=[];

        for ($i=0; $i<=count($chart); $i++) {
            $colours[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        }

        for ($i=0; $i < count($mtn); $i++) {
            $colourms[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        }

        $chardt['labels'] = (array_column($chart,"month"));
        $chardt['dataset'] = (array_column($chart,"total"));
        $chardt['colours'] = $colours;
        
        $charmt['labels'] = (array_column($mtn,"month"));
        $charmt['dataset'] = (array_column($mtn,"total"));
        $charmt['colours'] = $colourms;

        $consolidatedData = [
            'chardt'=>$chardt,
            'charmt'=>$charmt
        ];

        return response()->json($consolidatedData);

    }

    public function sms_logs(){

        $totalsms = DB::select("
            SELECT COUNT(*) AS total
            FROM bill_logs"
         );

        return $totalsms;

    }

    public function bulksmsdeliveryreports(Request $request)
    {

        // Handle the DLR webhook here
        $senderid = Request::createFromGlobals()->get('senderid');
        Log::info($senderid);

        $phonenum = Request::createFromGlobals()->get('phonenum');
        Log::info($phonenum);

        $dlrvalue = Request::createFromGlobals()->get('dlrvalue');
        Log::info($dlrvalue);

        $smscid = Request::createFromGlobals()->get('smscid');
        Log::info($smscid);

        $smsid = Request::createFromGlobals()->get('smsid');
        Log::info($smsid);

        $user_id = Request::createFromGlobals()->get('user_id');
        Log::info($user_id);

        $log_no = Request::createFromGlobals()->get('log_no');
        Log::info($log_no);

        $message = Request::createFromGlobals()->get('message');
        Log::info($message);

        $ts_stamp =\Carbon\Carbon::now()->toDateTimeString();
        Log::info($ts_stamp);
       
        switch ($dlrvalue) {
            case 8:
                
                DB::table('ost_bulksms_pending_sms')->insert([
                    'senderid' => $senderid,
                    'phonenum' => $phonenum,
                    'dlrvalue' => $dlrvalue,
                    'smscid' => $smscid,
                    'ts_stamp' => $ts_stamp,
                    'smsid' => $smsid,
                    'user_id' => $user_id,
                    'log_no'  => $log_no,
                    'list_id' => '0',
                    'bill_id' => '0',
                    'msg' => $message

                ]);
                break;
                default:
               
                DB::table('ost_dlr_reports')->insert([
                    'senderid' => $senderid,
                    'phonenum' => $phonenum,
                    'dlrvalue' => $dlrvalue,
                    'smscid' => $smscid,
                    'ts_stamp' => $ts_stamp,
                    'smsid' => $smsid,
                    'user_id' => $user_id,
                    'log_no'  => $log_no,
                    'list_id' => '0',
                    'bill_id' => '0',
                    'msg' => $message

                ]);

                Log::info("Delivery reports inserted successfully!");

            }


    }

    public function bulk_mtn()
    {

        $mtn =DB::select("SELECT count(phonenum) AS total FROM ost_dlr_reports WHERE  phonenum REGEXP '^2567[7|8|6]' and  MONTH(ts_stamp) = MONTH(now())");

        $total = $mtn[0]->total;

        return response()->json($total);
    }

    public function bulk_airtel()
    {

        $chart =DB::select("SELECT count(phonenum) AS total FROM ost_dlr_reports WHERE phonenum REGEXP '^2567[0|5|4]' and  MONTH(ts_stamp) = MONTH(now())");

        $total = $chart[0]->total;

        return response()->json($total);;
    }

    public function sms_units($id)
    {

        $user_credit = SmsCredit::firstOrCreate(['user_id' => $id,'currency' => "UGX"],[ 'units' => 0, 'smscost' => 0]);

        $sms_units =$user_credit->units;

        $sms_units =$user_credit->smscost;

        $totalcost = $sms_units*$user_credit->cost;

        return $totalcost;
    }

    public function num_lists()
    {

        $numkeywds = DB::select("
            SELECT COUNT(*) AS total
            FROM bcastlists"
         );

        return $numkeywds;

    }
}
