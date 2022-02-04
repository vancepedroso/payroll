<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payroll;
use App\Models\PayrollItems;
use App\Models\Employee;
use App\Models\EmployeeEarnings;
use App\Models\EmployeeDeduction;
use App\Models\Incentive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;

class PayrollController extends Controller
{
    public function index()
    {
      $payrolls = Payroll::all();
      return view('admin.payroll.index', compact('payrolls'));
    }

    public function create()
    {
      return view('admin.payroll.store');
    }

    public function store(Request $request)
    {
      $payroll = Payroll::create($request->all());

      if ($payroll)
        return 1;
      else
        return 0;
    }

    public function show(Request $request, $id)
    {
      $payroll = Payroll::find($id);
      $payrollItems = PayrollItems::select(
        'payroll_items.*',
        'payrolls.ref_no',
        'payrolls.dept_id',
        'payrolls.date_from',
        'payrolls.date_to',
        'payrolls.type',
      )
      ->leftjoin('payrolls','payrolls.id','=','payroll_items.payroll_id')
      ->where('payroll_items.payroll_id','=',$id)
      ->get();

      return view('admin.payroll.show', compact('payroll','payrollItems'));
    }

    public function edit($id)
    {
      $payroll = Payroll::find($id);
      return view('admin.payroll.update', compact('payroll'));
    }

    public function update(Request $request, $id)
    {
      $payroll = Payroll::findOrFail($id);
      $payroll->update($request->all());
      return 1;
    }

    public function destroy($id)
    {
      $payroll = Payroll::find($id);
      $payroll->delete();
      PayrollItems::where('payroll_id','=',$id)->delete();
      return 1;
    }

    public function searchEarningAmount($emp_id,$earning_id,$date_to,$type) {
      $result = EmployeeEarnings::select('amount')
      ->whereBetween('effective_date', [$date_to,date('Y-m-d', strtotime($date_to.'+5 days'))])
      ->orWhere('type','=',$type)
      ->where('emp_id','=',$emp_id)
      ->where('earning_id','=',$earning_id)
      ->first();

      if($result)
        return $result->amount;
      else
        return 0;
    }

    public function searchDeductionAmount($emp_id,$earning_id,$date_to,$type) {
      $result = EmployeeDeduction::select('amount')
      ->whereBetween('effective_date', [$date_to,date('Y-m-d', strtotime($date_to.'+5 days'))])
      ->orWhere('type','=',$type)
      ->where('emp_id','=',$emp_id)
      ->where('deduction_id','=',$earning_id)
      ->first();

      if($result)
        return $result->amount;
      else
        return 0;
    }

    public function calculate($id)
    {
      // Delete All Payroll Items
      PayrollItems::where('payroll_id','=',$id)->delete();

      // Select Payroll
      $payroll = Payroll::find($id);
      $begin   = strtotime($payroll->date_from);
      $end     = strtotime($payroll->date_to);
      $date_to = $payroll->date_to;
      $type    = $payroll->type;

      // Calculate Business Days
      $no_days  = 0;
      while ($begin <= $end) {
        $what_day = date("N", $begin);
        if (!in_array($what_day, [6,7]) ) // 6 and 7 are weekend
            $no_days++;
        $begin += 86400; // +1 day
      };

      // Get data records from DTR
      $employees2 = DB::connection('mysql2')->select("
        SELECT users.*,
        teams.team_name,
        positions.pos_name,
        records.user_id,
        SUM(Case When records.remarks = 'OT' then records.overtime else NULL end) AS total_overtime,
        SUM(Case When records.remarks = 'OT' then records.user_id else NULL end) AS days_overtime,
        SUM(Case When records.overbreak != ' ' then records.overbreak else NULL end) AS total_overbreak,
        COUNT(records.user_id) AS total_work_days,
        SUM(records.total_hours) As total_work_hours,
        COUNT(Case When records.time_in != ' ' then records.user_id else NULL end) AS present,
        COUNT(Case When records.remarks = 'A' OR records.remarks = 'VL' OR records.remarks = 'SL' OR records.remarks = 'S' then records.user_id else NULL end) AS absent,
        COUNT(Case When records.remarks = 'S' then records.user_id else NULL end) AS suspended,
        COUNT(Case When records.remarks = 'Training' OR records.remarks = 'First Day Dial' OR records.remarks = 'First Day Training' then records.user_id else NULL end) AS training_days,
        COUNT(Case When records.remarks = 'Training' OR records.remarks = 'First Day Dial' OR records.remarks = 'First Day Training' then records.total_hours else NULL end) AS training_hours
        FROM users
        LEFT JOIN role_user ON role_user.user_id = users.id
        LEFT JOIN teams ON teams.id = users.team_id
        LEFT JOIN positions ON positions.id = users.pos_id
        LEFT JOIN records ON records.user_id = users.id
        WHERE records.date BETWEEN '$payroll->date_from' AND '$payroll->date_to'
        AND users.team_id = $payroll->dept_id
        AND users.deleted_at IS NULL
        AND role_user.role_id IN (2,4)
        GROUP BY users.id
        ORDER BY users.first_name ASC
      ");
      // ")->toSql();

      // Earnings and Deductions to Create Payroll Items
      foreach ($employees2 as $employee) {

        // Initialization
        $ear_amount = 0;
        $ded_amount = 0;
        $incentive_amount = 0;
        $ot_pay = 0;
        $ear_arr = array();
        $ded_arr = array();
        $emp_id = $employee->id;
        $emp = Employee::select('rate_per_day')->where('emp_id','=',$emp_id)->first();

        if($emp)
          $rate_per_day = $emp->rate_per_day;
        else
          $rate_per_day = 0;

        if ($rate_per_day <> 0) 
          $ot_pay = $rate_per_day/8;

        $earnings = EmployeeEarnings::select('*')
        ->whereBetween('effective_date', [$payroll->date_to,date('Y-m-d', strtotime($payroll->date_to.'+5 days'))])
        ->orWhere('type','=',$payroll->type)
        ->where('emp_id','=',$employee->id)
        ->get();

        $deductions = EmployeeDeduction::select('*')
        ->whereBetween('effective_date', [$payroll->date_to,date('Y-m-d', strtotime($payroll->date_to.'+5 days'))])
        ->orWhere('type','=',$payroll->type)
        ->where('emp_id','=',$employee->id)
        ->get();

        $incentives = Incentive::select('*')
        ->where('emp_id','=',$employee->id)
        ->whereBetween('effective_date', [$payroll->date_to,date('Y-m-d', strtotime($payroll->date_to.'+5 days'))])
        ->get();

        $gross_pay = $rate_per_day*$employee->total_work_days;
        $absent_amount = $rate_per_day*$employee->absent;

        if (count($earnings)) {
          foreach ($earnings as $earning) {
            $ear_amount += $earning->amount;
            $ear_arr[] = array('eid' => $earning->earning_id,"amount" => $earning->amount);
          }
        }

        if (count($incentives)) {
          foreach ($incentives as $incentive) {
            $ear_amount += $incentive->amount;
            $incentive_amount += $incentive->amount;
          }
        }

        $ear_amount += $gross_pay;

        if (count($deductions)) {
          foreach ($deductions as $deduction) {
            $ded_amount += $deduction->amount;
            $ded_arr[] = array("did" => $deduction->deduction_id,"amount" => $deduction->amount);
          }
        }

        $query = PayrollItems::create([
          'payroll_id'              => $id,
          'emp_id'                  => $employee->id,
          'present'                 => $employee->present,
          'absent'                  => $employee->absent,
          'absent_amount'           => number_format($absent_amount,2),
          'late'                    => 0,
          'late_amount'             => number_format(0,2),
          'undertime'               => 0,
          'undertime_amount'        => number_format(0,2),
          'overtime'                => $employee->total_overtime?:0,
          'overtime_amount'         => number_format($employee->total_overtime*$ot_pay,2),
          'earning_amount'          => number_format($ear_amount,2),
          'earnings'                => json_encode($ear_arr),
          'deduction_amount'        => number_format($ded_amount,2),
          'deductions'              => json_encode($ded_arr),
          'rdot'                    => '',
          'total_regular_wdays'     => ($employee->present+$employee->absent),
          'total_wdays'             => $employee->total_work_days,
          'total_whours'            => $employee->total_work_hours,
          'training_days'           => $employee->training_days ,
          'training_hours'          => $employee->training_hours,
          'perfect_attendance_date' => '',
          'gross_pay'               => number_format($gross_pay,2),
          'allowance'               => number_format($this->searchEarningAmount($emp_id,1,$date_to,$type),2),
          'night_differential'      => number_format($this->searchEarningAmount($emp_id,2,$date_to,$type),2),
          'incentives'              => number_format($incentive_amount,2),
          'perfect_attendance_team' => number_format($this->searchEarningAmount($emp_id,3,$date_to,$type),2),
          'perfect_attendance'      => number_format($this->searchEarningAmount($emp_id,4,$date_to,$type),2),
          'holidays'                => '',
          'holiday_date'            => '',
          'holiday_amount'          => number_format(0,2),
          'regularization'          => number_format($this->searchEarningAmount($emp_id,5,$date_to,$type),2),
          'one_year'                => number_format($this->searchEarningAmount($emp_id,6,$date_to,$type),2),
          'referral'                => number_format($this->searchEarningAmount($emp_id,7,$date_to,$type),2),
          'appraisal'               => number_format($this->searchEarningAmount($emp_id,9,$date_to,$type),2),
          'dispute'                 => number_format($this->searchEarningAmount($emp_id,10,$date_to,$type),2),
          'suspension'              => number_format($employee->suspended,2),
          'salary_loans'            => number_format($this->searchDeductionAmount($emp_id,1,$date_to,$type),2),
          'benefits'                => number_format($this->searchDeductionAmount($emp_id,2,$date_to,$type),2),
          'net'                     => number_format($ear_amount - $ded_amount,2),
        ]);
      }

      // Change Status to "Calculated"
      $payroll->update(['status' => 1]);

      if($payroll)
        return 1;
        // return $employees2;
      else
        return 0;
    }
}
