<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmployeeEarnings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeEarningsController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

      foreach($request->earning_id as $k => $v){
        EmployeeEarnings::create([
          'emp_id' => $request->emp_id,
          'earning_id' => $request->earning_id[$k] ?:'',
          'type' => $request->type[$k] ?:'',
          'amount' => $request->amount[$k] ?:'',
          'effective_date' => $request->effective_date[$k] ?:'',
        ]);
      }

      return 1;
    }

    public function show($id)
    {

      $emp_id = $id;

      return view('admin.employeeEarnings.show', compact('emp_id'));
    }

    public function edit(EmployeeEarnings $employeeEarnings)
    {
        //
    }

    public function update(Request $request, EmployeeEarnings $employeeEarnings)
    {
        //
    }

    public function destroy($id)
    {
      $employee = EmployeeEarnings::find($id);
      $employee->delete();

      return 1;
    }
}
