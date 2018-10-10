<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TMS;

class TMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('tms.index');
    }

    public function create()
    {
        return view('tms.create');
    }

    public function edit($id)
    {
        return view("tms.edit", compact("id"));
    }

}
