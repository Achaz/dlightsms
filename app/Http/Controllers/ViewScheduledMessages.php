<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bill_log;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Utils\Paginate;

class ViewScheduledMessages extends Controller
{
    function index() {

        $scheduled_messages = \App\Models\ScheduledSms::all();
        
        $scheduled_messages = $scheduled_messages->transform(function ($item, $key) {

            switch ($item->sent) {
                case 1:
                    $item->sent = "SENT";
                    break;
                case 0:
                    $item->sent = "PENDING";
                    break;
                
            }

            return $item;
            
        })->toArray();

        $scheduled_messages= Paginate::paginate($scheduled_messages,5)->setPath(route('broadcasts.viewscheduledmessages'));
        //($scheduled_messages);
        // $pagination = new LengthAwarePaginator($scheduled_messages['total'], $scheduled_messages['per_page'],
        // $scheduled_messages['current_page'], ['path' => '/viewscheduledmessages']);
        return view('broadcasts.viewscheduledmessages', compact('scheduled_messages'));
    }

    function deleteMessage($id) {

        DB::table('scheduled_sms')->where('schedule_id', $id)->delete();

        return redirect('/viewscheduledmessages')->with('status', 'Message Deleted');
    }

}