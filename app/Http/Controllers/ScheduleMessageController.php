<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class ScheduleMessageController extends Controller
{
    public function index() {

        $names=Auth::user()->name;

        $id = Auth::user()->id; 

        $messages = \App\Models\Message::with('User')->get();

        $lists = \App\Models\Bcastlist::all();

        $networks = \App\Models\Network::all();
       
         return view('broadcasts.schedulemessage')->with('messages',$messages)->with('lists', $lists)->with('networks',$networks)->with('names',$names);
    }

    public function schedulemessage(Request $request){


        $id = Auth::user()->id; 

        $ts_stamp = \Carbon\Carbon::now()->toDateTimeString();
        /*
        $this->validate($request, [
            'sender_id' => 'required|unique:posts|max:255',
        ]);
        */
        $list_id=$request->list_id;
        $msg=$request->message;
        $title=$request->title;
        $senderid=$request->senderid;
        $network=$request->network;
        $scheduled_date=$request->scheduled_date;
    
        $rand_job_id = date('is');
        $job_id = $id.$list_id.$rand_job_id;

        DB::table('scheduled_sms')->insert([
            'sender_id' => $senderid,
            'message' => $msg,
            'list_id' => $list_id,      
            'user_id' => Auth::id(),
            'job_id' => $job_id,
            'due_datetime' => $scheduled_date,
            'def_date' => $ts_stamp,
            'sent' => '0'    
        ]);

        return redirect('/schedulesms')->with('status', 'Message Scheduled Successfully');

    }
}
