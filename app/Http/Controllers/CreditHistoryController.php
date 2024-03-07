<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Paginate;

class CreditHistoryController extends Controller
{
    public function index() 
    {
       $credithistories = \App\Models\SmsCreditHistory::with('User')->get()->toArray();
        
        //dd($credithistories->toArray());

        $credithistories = Paginate::paginate($credithistories,5)->setPath(route('credits.credithistories'));

        return view('credits.credithistories', compact('credithistories'));
        //$list->name

    }
}
