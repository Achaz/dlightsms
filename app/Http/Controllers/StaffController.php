<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;

class StaffController extends Controller
{
    public function index() 
    {
        // get data
        // staff with r/s list
        // $list
        $staffs = \App\Models\Staff::all();
        //dd($staffs->toArray());
        return view('accounts.index', compact('staffs'));
        //$list->name
    }

    public function addacount(Request $request)
    {

        $account = new Staff();
        $id = Auth::id(); 

        $account->username = $request->username;
        $account->default_senderid = $request->default_senderid;
        $account->firstname = $request->firstname;
        $account->lastname = $request->lastname;
        $account->passwd = $request->password;
        $account->email = $request->email;
        $account->mobile = $request->mobile;
        $account->isactive = $request->isactive;
        $account->isadmin = $request->isadmin;
        $account->isvisible = $request->isvisible;
        //$account->created_by= $id;
        $account->timestamps =false;
        $account->save();
   
        return redirect('/newaccount')->with('status', 'Account Has Been Created'); 

    }
}
