<?php

namespace App\Http\Controllers\Admin;

use App\Models\Incentive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncentiveController extends Controller
{
    public function index()
    {
      $incentives = Incentive::all();
      return view('admin.incentives.index', compact('incentives'));
    }

    public function create()
    {
      return view('admin.incentives.store');
    }

    public function store(Request $request)
    {
      Incentive::create($request->all());
      return 1;
    }

    public function show(Incentive $incentive)
    {
        //
    }

    public function edit($id)
    {
      $incentives = Incentive::find($id);
      
      return view('admin.incentives.edit', compact('incentives'));
    }

    public function update(Request $request, $id)
    {
      $incentives = Incentive::findOrFail($id);
      $incentives->update($request->all());

      return 1;
    }

    public function destroy($id)
    {
      $incentives = Incentive::find($id);
      $incentives->delete();
      return 1;
    }
}
