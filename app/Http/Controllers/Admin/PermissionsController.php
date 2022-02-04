<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Logs;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionsController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $permission = Permission::create($request->all());

        Logs::create([
            'action' => 'Created Permission : '.$request->title,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('admin.permissions.index');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $permission->update($request->all());

        Logs::create([
            'action' => 'Updated Permission : '.$request->title,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('admin.permissions.index');
    }

    public function show(Permission $permission)
    {
        return view('admin.permissions.show', compact('permission'));
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        Logs::create([
            'action' => 'Deleted Permission : '.$permission->title,
            'user_id' => auth()->user()->id
        ]);

        return back();
    }
}