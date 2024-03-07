<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Utils\Paginate;

class SmsReportController extends Controller
{
    public function index() 
    {

        if (request()->start_date_summary || request()->end_date_summary) {

            $start_date_summary = Carbon::parse(request()->start_date_summary)->toDateTimeString();
            $end_date_summary = Carbon::parse(request()->end_date_summary)->toDateTimeString();

            $data = DB::table('bill_logs')
            ->select(DB::raw("DATE_FORMAT(ts_stamp, '%Y-%m-%d') as day"), DB::raw("SUM(units) as total_sms"),"list_id","bcastlists.name as name")
            ->join('bcastlists', 'bill_logs.list_id', '=', 'bcastlists.id')
            ->whereBetween('ts_stamp',[$start_date_summary,$end_date_summary])
            ->groupBy('day','list_id','name')
            ->orderBy('day', 'desc')
            ->get();    

        }else{
          
            $data = DB::table('bill_logs')
            ->select(DB::raw("DATE_FORMAT(ts_stamp, '%Y-%m-%d') as day"), DB::raw("SUM(units) as total_sms"),"list_id","bcastlists.name as name")
            ->join('bcastlists', 'bill_logs.list_id', '=', 'bcastlists.id')
            ->groupBy('day','list_id','name')
            ->orderBy('day', 'desc')
            ->get();        

        }
        $summary_results = $data->toArray();
       
        $summary_results = Paginate::paginate($summary_results,5)->setPath(route('reports.smsreports'))->appends(['start_date_summary' => request()->start_date_summary, 'end_date_summary' => request()->end_date_summary]);

        return view('reports.smsreports')->with('smsreports_summary',$summary_results);
      
    }

    public function exportCSV(Request $request)
    {
        $fileName = 'bulksmsreport.csv';
        $tasks = DB::table('bill_logs')
        ->select(DB::raw("DATE_FORMAT(ts_stamp, '%Y-%m-%d') as day"), DB::raw("SUM(units) as total_sms"),"list_id","bcastlists.name as name")
        ->join('bcastlists', 'bill_logs.list_id', '=', 'bcastlists.id')
        ->groupBy('day','list_id','name')
        ->orderBy('day', 'desc')
        ->get();    

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('List', 'Total SMS', 'Timestamp');

        $callback = function() use($tasks, $columns) {

            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                $row['List']  = $task->name ?? 'name missing';
                $row['Total SMS']    = $task->total_sms;
                $row['Timestamp']    = $task->day;
                

                fputcsv($file, array($row['List'], $row['Total SMS'], $row['Timestamp']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
