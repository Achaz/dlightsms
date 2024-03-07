<?php

namespace App\Http\Controllers;

use App\Utils\Paginate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MoSmsController extends Controller
{
    public function index() 
    {

        $mosms = \App\Models\MO_SMS::select(DB::raw("DATE_FORMAT(ts_stamp, '%Y-%m-%d') as day"),"sender","request","keywd","created","status")
        ->orderBy('day', 'desc')
        ->get()->toArray();
        $mosms = Paginate::paginate($mosms,5)->setPath(route('broadcasts.mosms'));
        return view('broadcasts.mosms', compact('mosms'));

    }

    public function details(Request $request)
    {

        if (request()->start_date || request()->end_date) {

            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            //$apideliveryreports = \App\Models\ApiBillLog::whereBetween('ts_stamp',[$start_date,$end_date])->get();
            $mosms = \App\Models\MO_SMS::select(DB::raw("DATE_FORMAT(ts_stamp, '%Y-%m-%d') as day"),"sender","request","keywd","created","status")
            ->whereBetween('ts_stamp',[$start_date,$end_date])
            ->orderBy('day', 'desc')
            ->get()->toArray();; 

        }else {

            $mosms = \App\Models\MO_SMS::select(DB::raw("DATE_FORMAT(ts_stamp, '%Y-%m-%d') as day"),"sender","request","keywd","created","status")
            ->orderBy('day', 'desc')
            ->get()->toArray();  

        }

        $mosms = Paginate::paginate($mosms,5)->setPath(route('broadcasts.mosmsdetails'));
        
        return view('broadcasts.mosms', compact('mosms'));

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
        DB::table('mo_sms')->insert([
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


    }

    public function exportCSV(Request $request)
    {
        $fileName = 'mo_sms.csv';
        $tasks = \App\Models\MO_SMS::select(DB::raw("DATE_FORMAT(ts_stamp, '%Y-%m-%d') as day"), "sender","request","keywd","created","status")
        ->groupBy('day','sender','request','keywd','created','status')
        ->orderBy('day', 'desc')
        ->get();  

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Sender','Request','Keywd','created','Status','ts_stamp');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {

                $row['Sender'] = $task->sender;
                $row['Request']  = $task->request;
                $row['Keywd']    = $task->keywd;
                $row['created'] = $task->created;
                $row['Status'] = $task->status;
                $row['ts_stamp'] = $task->day;

                fputcsv($file, array($row['Sender'], $row['Request'], $row['Keywd'], $row['created'], $row['Status'], $row['ts_stamp']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
