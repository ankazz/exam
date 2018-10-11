<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Authenticatable, Authorizable, CanResetPassword, HasRoles;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        return view('home');
    }

    public function job()
    {
        $user = Auth::user();
        return view('job.index');
    }

    public function post()
    {
        $user = Auth::user();
        return view('post.index');
    }

    public function student()
    {
        $user = Auth::user();
        return view('student.index');
    }

    public function category()
    {
        $user = Auth::user();
        return view('category.index');
    }
}
