<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Paginate;

class CreditsController extends Controller
{
    public function index() 
    {
        // get data
        // staff with r/s list
        // $list
        //$staff = \App\Models\Staff::all();
        $credits = \App\Models\SmsCredit::with('User')->get()->toArray();
        //$credits->toArray();        
        //dd($staff->toArray()->$credit);

        $credits = Paginate::paginate($credits,5)->setPath(route('credits.index'));

        return view('credits.index', compact('credits'));
        //$list->name
    }
}
