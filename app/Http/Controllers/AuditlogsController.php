<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditlogsController extends Controller
{
    public function index() 
    {
        // get data
        // staff with r/s list
        // $list
        $auditlogs = \App\Models\Auditlog::all();
        //($auditlogs->toArray());
        return view('reports.audittrail', compact('auditlogs'));
        //$list->name
    }
}
