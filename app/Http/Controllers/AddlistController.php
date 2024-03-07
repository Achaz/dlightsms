<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bcastlist;

class AddlistController extends Controller
{
    public function index() 
    {
        $name=Auth::user()->name;
        
        return view('lists.addlist')->with('names',$name);
        //$list->name
    }

    public function storelist(Request $request){

        $this->validate($request, [
                'list_name' => 'required|unique:bcastlists,name'
            ]
        );

        Bcastlist::create([
            'name' => $request->list_name,
            'description' => $request->desc,
            'created_by' => Auth::id(),
        ]);
   
        return redirect('/addlist')->with('status', 'List Has Been Created');

    }
    
}
