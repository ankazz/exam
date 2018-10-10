<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
//use App\Role;
use View;
use DB;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

  

class UserController extends Controller
{
    use HasRoles;

    private $rules = [
        'name' => 'required',
        'email' => 'required'
    ];

    public function index()
    {
        $users = User::all();
        return View::make('users.index')->with('users',$users);
    }

    public function edit($id)
    {
        $user = User::find($id);


        //$role = Role::create(['name' => 'admin']);
        //$permission = Permission::create(['name' => 'super user']);
        //$user->assignRole('admin');

        $roles = $user->getRoleNames();
        $items = Role::all(['id', 'name']);
        return view("users.edit", compact('user','items'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, $this->rules);

        $user = User::find($id);
        $data = $request->all();
        $user->update($data);

        $users = User::all();
        return redirect()->route('userIndex')->with('users',$users);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        $user = User::all();
        return redirect()->route('userIndex')->with('sections',$user);
    }

    public function getRoles($id)
    {
        //$users = User::all();
        $users = DB::select('SELECT id,name FROM vw_user_roles WHERE (model_id = ? or model_id is null) group by id,name', [$id]);
        return $users;
    }

    public function updateRole(Request $request)
    {
        $user = User::find($request->input('id_user'));
        $var = $user->syncRoles($request->input('selected_f'));
        return $var;
    }
}
