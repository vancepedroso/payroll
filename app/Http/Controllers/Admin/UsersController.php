<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Logs;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all()->pluck('title', 'id');
        return view('admin.users.index', compact('users','roles'));
    }

    public function create()
    {
        $roles = Role::all()->pluck('title', 'id');
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        Logs::create([
            'action' => 'Created User : '.$request->name,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all()->pluck('title', 'id');
        $user->load('roles');
        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(Request $request, $id)
    {   
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request['name2'],
            'email' => $request['email2'],
            'password' => $request['password2'],
        ]);

        $user->roles()->sync($request->input('roles2', []));

        Logs::create([
            'action' => 'Updated User : '.$request->name,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        $user->load('roles');
        return view('admin.users.show', compact('user'));
    }

    public function destroy( $id)
    {   
        $user = User::findOrFail($id);
        $user->delete();

        Logs::create([
            'action' => 'Deleted User : '.$user->name,
            'user_id' => auth()->user()->id
        ]);

        return back();
    }
}