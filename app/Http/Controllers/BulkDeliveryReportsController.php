<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Utils\Paginate;


class BulkDeliveryReportsController extends Controller
{
    public function index() 
    {

        if (request()->start_date || request()->end_date) {

            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            //$bulkdeliveryreports = \App\Models\BulkDeliveryReports::whereBetween('ts_stamp',[$start_date,$end_date])->get();

            $bulkdeliveryreports = \App\Models\BulkDeliveryReports::select(DB::raw("DATE_FORMAT(ts_stamp, '%Y-%m-%d') as day"), DB::raw("COUNT(*) as total_sms"),"dlrvalue","senderid")
            ->whereBetween('ts_stamp',[$start_date,$end_date])
            ->groupBy('day','dlrvalue','senderid')
            ->orderBy('day', 'desc')
            ->get();

            $bulkdeliveryreports = $bulkdeliveryreports->transform(function ($item, $key) {

                switch ($item->dlrvalue) {

                    case 1:
                        $item->dlrvalue = "DELIVRD";
                        break;
                    case 2:
                        $item->dlrvalue = "NOT-DELIVRD TO PHONE";
                        break;
                    case 4:
                        $item->dlrvalue = "QUEUED ON SMSC";
                        break;           
                    case 8:
                        $item->dlrvalue = "SENT TO SMSC";
                        break;
                    case 16:
                        $item->dlrvalue = "NON-DELIVRD TO SMSC";
                        break;
                    case 34:
                        $item->dlrvalue = "EXPIRED";
                        break;
                }
                return $item;

            })->toArray();

        } else {

            //$bulkdeliveryreports = \App\Models\BulkDeliveryReports::all();
            $bulkdeliveryreports = \App\Models\BulkDeliveryReports::select(DB::raw("DATE_FORMAT(ts_stamp, '%Y-%m-%d') as day"), DB::raw("COUNT(*) as total_sms"),"dlrvalue","senderid")
            ->groupBy('day','dlrvalue','senderid')
            ->orderBy('day', 'desc')
            ->get();  

            $bulkdeliveryreports = $bulkdeliveryreports->transform(function ($item, $key) {

                switch ($item->dlrvalue) {

                    case 1:
                        $item->dlrvalue = "DELIVRD";
                        break;
                    case 2:
                        $item->dlrvalue = "NOT-DELIVRD TO PHONE";
                        break;
                    case 4:
                        $item->dlrvalue = "QUEUED ON SMSC";
                        break;           
                    case 8:
                        $item->dlrvalue = "SENT TO SMSC";
                        break;
                    case 16:
                        $item->dlrvalue = "NON-DELIVRD TO SMSC";
                        break;
                    case 34:
                        $item->dlrvalue = "EXPIRED";
                        break;
                }
                return $item;

            })->toArray();

        }

        $bulkdeliveryreports = Paginate::paginate($bulkdeliveryreports,5)->setPath(route('reports.bulkdeliveryreports'))->appends(['start_date' => request()->start_date, 'end_date' => request()->end_date]);

        return view('reports.bulkdeliveryreports', compact('bulkdeliveryreports'));
        //$list->name
    }

    public function exportCSV(Request $request)
    {
        if ($request->start_date || $request->end_date){

            $start_date = Carbon::parse($request->start_date)->toDateTimeString();
            $end_date = Carbon::parse($request->end_date)->toDateTimeString();

            $fileName = 'bulk_delivery_report.csv';

            $tasks = \App\Models\BulkDeliveryReports::select(DB::raw("DATE_FORMAT(ts_stamp, '%Y-%m-%d') as day"), DB::raw("COUNT(*) as total_sms"),"dlrvalue","senderid")
            ->whereBetween('ts_stamp',[$start_date,$end_date])
            ->groupBy('day','dlrvalue','senderid')
            ->orderBy('day', 'desc')
            ->get();  

            $tasks = $tasks->transform(function ($item, $key) {

                switch ($item->dlrvalue) {

                    case 1:
                        $item->dlrvalue = "DELIVRD";
                        break;
                    case 2:
                        $item->dlrvalue = "NOT-DELIVRD TO PHONE";
                        break;
                    case 4:
                        $item->dlrvalue = "QUEUED ON SMSC";
                        break;           
                    case 8:
                        $item->dlrvalue = "SENT TO SMSC";
                        break;
                    case 16:
                        $item->dlrvalue = "NON-DELIVRD TO SMSC";
                        break;
                    case 34:
                        $item->dlrvalue = "EXPIRED";
                        break;
                }
                return $item;

            })->toArray();

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            $columns = array('Sender ID', 'DateTime', 'Status', 'Total SMS');

            $callback = function() use($tasks, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($tasks as $task) {

                    $row['Sender ID'] = $task['senderid'];
                    $row['DateTime']  = $task['day'];
                    $row['Status']    = $task['dlrvalue'];
                    $row['Total SMS'] = $task['total_sms'];
                    

                    fputcsv($file, array($row['Sender ID'], $row['DateTime'], $row['Status'], $row['Total SMS']));
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        }else{

            $fileName = 'bulk_delivery_report.csv';

            $tasks = \App\Models\BulkDeliveryReports::select(DB::raw("DATE_FORMAT(ts_stamp, '%Y-%m-%d') as day"), DB::raw("COUNT(*) as total_sms"),"dlrvalue","senderid")
            ->groupBy('day','dlrvalue','senderid')
            ->orderBy('day', 'desc')
            ->get();  

            $tasks = $tasks->transform(function ($item, $key) {

                switch ($item->dlrvalue) {

                    case 1:
                        $item->dlrvalue = "DELIVRD";
                        break;
                    case 2:
                        $item->dlrvalue = "NOT-DELIVRD TO PHONE";
                        break;
                    case 4:
                        $item->dlrvalue = "QUEUED ON SMSC";
                        break;           
                    case 8:
                        $item->dlrvalue = "SENT TO SMSC";
                        break;
                    case 16:
                        $item->dlrvalue = "NON-DELIVRD TO SMSC";
                        break;
                    case 34:
                        $item->dlrvalue = "EXPIRED";
                        break;
                }
                return $item;

            })->toArray();

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            $columns = array('Sender ID', 'DateTime', 'Status', 'Total SMS');

            $callback = function() use($tasks, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($tasks as $task) {

                    $row['Sender ID'] = $task['senderid'];
                    $row['DateTime']  = $task['day'];
                    $row['Status']    = $task['dlrvalue'];
                    $row['Total SMS'] = $task['total_sms'];
                    

                    fputcsv($file, array($row['Sender ID'], $row['DateTime'], $row['Status'], $row['Total SMS']));
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);


        }
        
    }

    
}
