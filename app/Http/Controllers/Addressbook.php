<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class Addressbook extends Controller
{
    public function index($status = null) 
    {
        $numbers = \App\Models\BcastNumbers::sortable()->paginate(5);

        //$numbers = DB::table('bcast_numbers')->sortable()->paginate(15);

        //dd($numbers->toArray());
        $results = $numbers->toArray();

        $pagination = new LengthAwarePaginator($results['data'], $results['total'], $results['per_page'],
        $results['current_page'], ['path' => '/addressbook']);

        return view('lists.addressbook')->with('numbers',$numbers)->with('pagination',$pagination)->with(['status' => $status]);
        
        //return view('lists.addressbook', compact('numbers'));
    }

    public function deleteaddressbookcontact(Request $request)
    {

        DB::table('bcast_list_maps')->where('num_id', $request->num_id)->delete();

        DB::table('bcast_numbers')->where('id', $request->num_id)->delete();
       
        $msg = "Contact deletion successful";

        return $this->index($msg);       

    }
   
}
