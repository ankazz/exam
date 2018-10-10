<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('task.index');
    }

    public function create()
    {
        return view('task.create');
    }

    public function edit($id)
    {
        return view("task.edit", compact("id"));
    }
}
