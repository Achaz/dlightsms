<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditContactct extends Controller
{
    public function index() 
    {
        return view('lists.edit');
    }
}
