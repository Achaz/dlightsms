<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class SmsTemplateController extends Controller
{
    public function index() 
    {
        $name=Auth::user()->name;
        // get data
        // staff with r/s list
        // $list
        $accounts = \App\Models\Staff::all();
        //$apideliveryreports = \App\Models\ApiBillLog::all();
        //dd($apideliveryreports->toArray());
        return view('broadcasts.smstemplate')->with('accounts',$accounts)->with('names', $name);
        //$list->name
    }

    public function addtemplate(Request $request)
    {
        $msg = new Message();
        $id = Auth::id(); 

        $msg->user_id = $request->user_id;
        $msg->msg = $request->smstemp;
        // $msg->created_by= $id;
        $msg->timestamps =false;
        $msg->save();
   
        return redirect('/smstemplates')->with('status', 'Template Has Been Created');
    }
}
