<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Addcontact extends Controller
{
    public function index() 
    {
        return view('lists.addcontact');
    }
}
