<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('service.index');
    }

    public function create()
    {
        return view('service.create');
    }

    public function edit($id)
    {
        return view("service.edit", compact("id"));
    }
}
