<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\Earning;
use App\Models\Deduction;
use App\Models\EmployeeEarnings;
use App\Models\EmployeeDeduction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class EmployeeController extends Controller
{
    public function index()
    {

      // $query = DB::connection('mysql2')->table('u560783370_dtr.users as dt1')
      // ->leftjoin('u560783370_dtr.role_user as dt2', 'dt2.user_id', '=', 'dt1.id')
      // ->leftjoin('u560783370_dtr.teams as dt3', 'dt3.id', '=', 'dt1.team_id')
      // ->leftjoin('u560783370_dtr.positions as dt4', 'dt4.id', '=', 'dt1.pos_id')
      // ->leftjoin('u560783370_payroll.employees as dt5', 'dt5.emp_id', '=', 'dt1.id')
      // ->whereNull('dt1.deleted_at')
      // ->whereIn('dt2.role_id',array(2,4))
      // ->orderByRaw('dt1.team_id+0 ASC')
      // ->orderBy('dt1.first_name','ASC');

      // $employees = $query->select([
      //   'dt1.*',
      //   'dt3.team_name',
      //   'dt4.pos_name',
      //   'dt5.id as main_emp_id',
      //   'dt5.emp_id',
      //   'dt5.bank',
      //   'dt5.account',
      //   'dt5.rate_per_day',
      //   'dt5.rdot_per_day',
      //   'dt5.sss',
      //   'dt5.philhealth',
      //   'dt5.pagibig'
      // ])->get();

      $employees = DB::connection('mysql2')->select("
        SELECT users.*, teams.team_name, positions.pos_name
        FROM users
        LEFT JOIN role_user ON role_user.user_id = users.id
        LEFT JOIN teams ON teams.id = users.team_id
        LEFT JOIN positions ON positions.id = users.pos_id
        WHERE users.deleted_at IS NULL
        AND role_user.role_id IN (2,4)
        ORDER BY users.team_id+0 ASC, users.first_name ASC
      ");

      return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
      Employee::create($request->all());

      return 1;
    }

    public function show($id)
    {
      $query = DB::connection('mysql2')->table('u560783370_dtr.users as dt1')
      ->where('dt1.id','=',$id)
      ->leftjoin('u560783370_dtr.role_user as dt2', 'dt2.user_id', '=', 'dt1.id')
      ->leftjoin('u560783370_dtr.teams as dt3', 'dt3.id', '=', 'dt1.team_id')
      ->leftjoin('u560783370_dtr.positions as dt4', 'dt4.id', '=', 'dt1.pos_id');

      $employee = $query->select([
        'dt1.*',
        'dt3.team_name',
        'dt4.pos_name',
      ])->first();

      $employee_earnings = EmployeeEarnings::select('employee_earnings.*','earnings.earning')
      ->leftjoin('earnings','earnings.id','=','employee_earnings.earning_id')
      ->where('employee_earnings.emp_id','=',$id)
      ->orderBy('employee_earnings.type')
      ->orderBy('employee_earnings.effective_date')
      ->orderBy('earnings.earning')
      ->get();

      $employee_deduction = EmployeeDeduction::select('employee_deductions.*','deductions.deduction')
      ->leftjoin('deductions','deductions.id','=','employee_deductions.deduction_id')
      ->where('employee_deductions.emp_id','=',$id)
      ->orderBy('employee_deductions.type')
      ->orderBy('employee_deductions.effective_date')
      ->orderBy('deductions.deduction')
      ->get();
      
      return view('admin.employees.show', compact('employee','employee_earnings','employee_deduction'));
    }

    public function edit($id)
    {

      $employee = Employee::where('emp_id','=',$id)->first();

      if (!$employee) {
        $employee = new Employee;
      }

      $query = DB::connection('mysql2')->table('u560783370_dtr.users as dt1')
      ->where('dt1.id','=',$id)
      ->leftjoin('u560783370_dtr.role_user as dt2', 'dt2.user_id', '=', 'dt1.id')
      ->leftjoin('u560783370_dtr.teams as dt3', 'dt3.id', '=', 'dt1.team_id')
      ->leftjoin('u560783370_dtr.positions as dt4', 'dt4.id', '=', 'dt1.pos_id');

      $employee2 = $query->select([
        'dt1.*',
        'dt3.team_name',
        'dt4.pos_name',
      ])->first();

      return view('admin.employees.edit', compact('employee','employee2'));
    }

    public function update(Request $request, $id)
    {
      $employee = Employee::findOrFail($id);
      $employee->update($request->all());

      return 2;
    }

    public function destroy($id)
    {
      $employee = Employee::find($id);
      $employee->delete();

      return 1;
    }
}
