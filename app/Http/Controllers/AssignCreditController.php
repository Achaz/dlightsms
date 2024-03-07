<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmsCreditHistory;
use App\Models\SmsCredit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignCreditController extends Controller
{
    public function index() 
    {
        $name=Auth::user()->name;
        // get data
        // staff with r/s list
        // $list
        //$staffs = \App\Models\Staff::all();
        $users = \App\Models\User::all();
        //dd($staffs->toArray());
        return view('credits.assigncredit')->with('names',$name)->with('users',$users);
        //return view('credits.assigncredit', compact('staffs'));
        //$list->name
    }

    public function addcredit(Request $request)
    {

        $credits = new SmsCreditHistory();
        $id = Auth::id(); 

        $credits->user_id = $request->user_id;
        $credits->units_used = $request->units;
      //  $credits->smscost = $request->smscost;
        $credits->action = "CREDIT";
        $credits->admin_id=$id;
        $credits->timestamps =false;
        $credits->save();
        $user_credit = SmsCredit::firstOrCreate(['user_id' => $request->user_id,'currency' => "UGX"],[ 'units' => 0, 'smscost' => 0]);
        $user_credit->units += $request->units;
        $user_credit->smscost = $request->smscost;

        $user_credit->save();
        
   
        return redirect('/assigncredit')->with('status', 'Account successfully credited');

    }
}
