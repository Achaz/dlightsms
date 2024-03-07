<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewNumbersController extends Controller
{
    public function index() 
    {
        return view('lists.viewnums');
    }
}
