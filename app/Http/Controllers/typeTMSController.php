<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class typeTMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('ttms.index');
    }

    public function create()
    {
        return view('ttms.create');
    }

    public function edit($id)
    {
        return view("ttms.edit", compact("id"));
    }
}
