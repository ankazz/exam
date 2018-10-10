<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EdIzmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('edizm.index');
    }

    public function create()
    {
        return view('edizm.create');
    }

    public function edit($id)
    {
        return view("edizm.edit", compact("id"));
    }
}
