<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeleteContact extends Controller
{
    public function index() 
    {
        return view('lists.delcontact');
    }
}
