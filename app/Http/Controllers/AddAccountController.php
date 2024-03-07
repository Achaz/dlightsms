<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddAccountController extends Controller
{
    public function index() 
    {
        return view('accounts.newaccount');
    }
}
