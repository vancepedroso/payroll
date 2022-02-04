<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Logs;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->pluck('title', 'id');
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        Logs::create([
            'action' => 'Created Role : '.$request->title,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->pluck('title', 'id');

        $role->load('permissions');

        return view('admin.roles.edit', compact('permissions', 'role'));
    }

    public function update(Request $request, Role $role)
    {
        $role->update($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        Logs::create([
            'action' => 'Updated Role : '.$request->title,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('admin.roles.index');
    }

    public function show(Role $role)
    {
        $role->load('permissions');

        return view('admin.roles.show', compact('role'));
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        Logs::create([
            'action' => 'Deleted Role : '.$role->title,
            'user_id' => auth()->user()->id
        ]);

        return back();
    }
}