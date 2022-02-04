<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmployeeDeduction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeDeductionController extends Controller
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
      foreach($request->deduction_id as $k => $v){
        EmployeeDeduction::create([
          'emp_id' => $request->emp_id,
          'deduction_id' => $request->deduction_id[$k] ?:'',
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

      return view('admin.employeeDeduction.show', compact('emp_id'));
    }

    public function edit(EmployeeDeduction $employeeDeduction)
    {
        //
    }

    public function update(Request $request, EmployeeDeduction $employeeDeduction)
    {
        //
    }

    public function destroy($id)
    {
      $employee = EmployeeDeduction::find($id);
      $employee->delete();

      return 1;
    }
}
