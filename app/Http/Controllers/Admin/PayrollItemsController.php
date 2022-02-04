<?php

namespace App\Http\Controllers\Admin;

use App\Models\PayrollItems;
use App\Models\Employee;
use App\Models\EmployeeEarnings;
use App\Models\EmployeeDeduction;
use App\Models\Incentive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Storage;

class PDF extends Fpdf
{
  var $angle=0;

  function Header()
  {
      //Put the watermark
      $this->SetFont('Arial','B',75);
      $this->SetTextColor(239, 239, 239);
      $this->RotatedText(50,190,'CONFIDENTIAL',45);
  }

  function RotatedText($x, $y, $txt, $angle)
  {
      //Text rotated around its origin
      $this->Rotate($angle,$x,$y);
      $this->Text($x,$y,$txt);
      $this->Rotate(0);
  }

  function Rotate($angle,$x=-1,$y=-1)
  {
    if($x==-1)
      $x=$this->x;
    if($y==-1)
      $y=$this->y;
    if($this->angle!=0)
      $this->_out('Q');
    $this->angle=$angle;
    if($angle!=0)
    {
      $angle*=M_PI/180;
      $c=cos($angle);
      $s=sin($angle);
      $cx=$x*$this->k;
      $cy=($this->h-$y)*$this->k;
      $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
    }
  }

  function _endpage()
  {
    if($this->angle!=0)
    {
      $this->angle=0;
      $this->_out('Q');
    }
    parent::_endpage();
  }
}

class PayrollItemsController extends Controller
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
        //
    }

    public function show($id)
    {
      $pi = PayrollItems::select(
        'payroll_items.*',
        'employees.bank',
        'employees.account',
        'employees.rate_per_day',
        'employees.rdot_per_day',
        'employees.sss',
        'employees.philhealth',
        'employees.pagibig',
        'payrolls.ref_no',
        'payrolls.dept_id',
        'payrolls.date_from',
        'payrolls.date_to',
        'payrolls.type',
      )
      ->leftjoin('employees','employees.emp_id','=','payroll_items.emp_id')
      ->leftjoin('payrolls','payrolls.id','=','payroll_items.payroll_id')
      ->where('payroll_items.id','=',$id)
      ->first();
      // ->toSql();dd($pi );

      if(!$pi)
        return view('layouts.error-404');

      $inc = Incentive::select('*')
      ->where('emp_id','=',$pi->emp_id)
      ->whereBetween('effective_date', [$pi->date_to,date('Y-m-d', strtotime($pi->date_to.'+5 days'))])
      ->first();

      $emp = new Employee();
      $fpdf = new PDF('P','mm',array(279.4,215.9));
      $fpdf->AddPage();

      // THE LAUNCHPAD INC
      $fpdf->SetFont('Arial','B',14);
      $fpdf->SetFillColor(255,0,0);
      $fpdf->SetTextColor(255,255,255);
      $fpdf->SetLineWidth(.5);
      $fpdf->Cell(190,8,'The Launchpad Inc.',1,1,'C',true);

      // LOGO
      $fpdf->SetFillColor(238, 236, 225);
      $fpdf->SetTextColor(0,0,0);
      $fpdf->SetFont('Arial','I',10);
      $fpdf->Cell(190,5,'Top Floor BLVD Center, Quezon Blvrd. Davao City','LR',1,'R',true);
      $fpdf->Cell(190,5,'Email: humanresource@thelaunchpadteam.com','LR',1,'R',true);
      $fpdf->Cell(190,5,'Contact #: (082) 228-2646','LR',1,'R',true);
      $fpdf->Image('lp_logo.png',13,19,50,13);


      // SALARY SLIP
      $fpdf->SetFont('Arial','B',14);
      $fpdf->SetFillColor(255, 255, 0);
      $fpdf->SetTextColor(0,0,0);
      $fpdf->Cell(190,8,'SALARY SLIP',1,1,'C',true);
      // 1
      $fpdf->SetFont('Arial','B',8);
      $fpdf->Cell(47.5,5,'Employee Name',1);
      $fpdf->SetTextColor(255,0,0);
      $fpdf->Cell(47.5,5,strtoupper($emp->SearchEmployeeById($pi->emp_id)),1,0,'C');
      $fpdf->SetTextColor(0,0,0);
      $fpdf->Cell(47.5,5,'Rate Per Day / Hr',1);
      $fpdf->Cell(47.5,5,$pi->rate_per_day ? 'P '.number_format($pi->rate_per_day,2).' / '.($pi->rate_per_day/8) : 'None',1,1,'C');
      // 2
      $fpdf->Cell(47.5,5,'Account Number',1);
      $fpdf->Cell(47.5,5,$pi->account?:'None',1,0,'C');
      $fpdf->Cell(47.5,5,'RDOT Date:',1);
      $fpdf->Cell(47.5,5,$pi->rdot ? date('M d, Y', strtotime($pi->rdot)) : 'None',1,1,'C');
      // 3
      $fpdf->Cell(47.5,5,'Pay Out Date',1);
      $fpdf->Cell(47.5,5,date('M d, Y', strtotime($pi->date_to.'+5 days')),1,0,'C');
      $fpdf->Cell(47.5,5,'Total Work Day / Hr',1);
      $fpdf->Cell(47.5,5,$pi->total_wdays ? $pi->total_wdays.' days / '.($pi->total_wdays*8).' hrs' : 'None',1,1,'C');
      // 4
      $fpdf->Cell(47.5,5,'Pay Period',1);
      $fpdf->Cell(47.5,5,date('M d, Y', strtotime($pi->date_from)).' - '.date('M d, Y', strtotime($pi->date_to)),1,0,'C');
      $fpdf->Cell(47.5,5,'No Work / Holiday',1);
      $fpdf->Cell(47.5,5,$pi->holiday_date ? date('M d, Y', strtotime($pi->holiday_date)) : 'None',1,1,'C');
      // 5
      $fpdf->Cell(47.5,5,'Perfect Attendance',1);
      $fpdf->Cell(47.5,5,$pi->perfect_attendance_date ? date('M d, Y', strtotime($pi->perfect_attendance_date)): 'None',1,0,'C');
      $fpdf->Cell(47.5,5,'Sales Incentives',1);
      if($inc){
        $fpdf->Cell(47.5,5,date('M d, Y',strtotime(substr($inc->date_from_to,0,10))).' - '.date('M d, Y', strtotime(substr($inc->date_from_to,13))),1,1,'C');
      }else{
        $fpdf->Cell(47.5,5,'None',1,1,'C');
      }


      // SCALE PAYMENT
      $fpdf->SetFont('Arial','B',10);
      $fpdf->SetFillColor(0,0,0);
      $fpdf->SetTextColor(255,255,255);
      $fpdf->Cell(190,5,'SCALE PAYMENT',1,1,'C',true);
      // 1
      $fpdf->SetFont('Arial','B',8);
      $fpdf->SetTextColor(0,0,0);
      $fpdf->Cell(47.5,5,'Total Regular Work Days',1);
      $fpdf->Cell(47.5,5,$pi->total_regular_wdays ? $pi->total_regular_wdays.' days' : 'None',1,0,'C');
      $fpdf->Cell(47.5,5,'Absent / VL / SL / Suspension',1);
      $fpdf->Cell(47.5,5,$pi->absent ? $pi->absent.' days' : 'None',1,1,'C');
      // 2
      $fpdf->Cell(47.5,5,'Total Work Hours',1);
      $fpdf->Cell(47.5,5,$pi->total_wdays ? ($pi->total_wdays*8).' hrs' : 'None',1,0,'C');
      $fpdf->Cell(47.5,5,'Total Training Days',1);
      $fpdf->Cell(47.5,5,$pi->training_days ? $pi->training_days.' days' : 'None',1,1,'C');
      // 3
      $fpdf->Cell(47.5,5,'Minutes Late',1);
      $fpdf->Cell(47.5,5,$pi->late ? $pi->late.' min' : 'None',1,0,'C');
      $fpdf->Cell(47.5,5,'Total Training Hours',1);
      $fpdf->Cell(47.5,5,$pi->training_hours ? $pi->training_hours.' hrs' : 'None',1,1,'C');
      // 4
      $fpdf->Cell(47.5,5,'Minutes Undertime',1);
      $fpdf->Cell(47.5,5,$pi->undertime ? $pi->undertime.' min' : 'None',1,0,'C');
      $fpdf->Cell(47.5,5,'Hours of Overtime',1);
      $fpdf->Cell(47.5,5,$pi->overtime ? $pi->overtime.' hrs' : 'None',1,1,'C');


      // EARNINGS AND DEDUCTIONS
      $fpdf->SetFont('Arial','B',10);
      $fpdf->SetFillColor(0,0,0);
      $fpdf->SetTextColor(255,255,255);
      $fpdf->Cell(95,5,'EARNINGS',1,0,'C',true);
      $fpdf->Cell(95,5,'DEDUCTIONS',1,1,'C',true);
      // 1
      $fpdf->SetFont('Arial','B',8);
      $fpdf->SetTextColor(0,0,0);
      $fpdf->Cell(47.5,5,'Gross Pay',1);
      $fpdf->SetTextColor(0,0,255);
      $fpdf->Cell(47.5,5,$pi->gross_pay,1,0,'R');
      $fpdf->SetTextColor(0,0,0);
      $fpdf->Cell(47.5,5,'Absent / LWOP / No Work',1);
      $fpdf->Cell(47.5,5,$pi->absent_amount,1,1,'R');
      // 2
      $fpdf->Cell(47.5,5,'Allowance',1);
      $fpdf->Cell(47.5,5,$pi->allowance,1,0,'R');
      $fpdf->Cell(47.5,5,'Late',1);
      $fpdf->Cell(47.5,5,$pi->late_amount,1,1,'R');
      // 3
      $fpdf->Cell(47.5,5,'Night Differential',1);
      $fpdf->Cell(47.5,5,$pi->night_differential,1,0,'R');
      $fpdf->Cell(47.5,5,'Undertime',1);
      $fpdf->Cell(47.5,5,$pi->undertime_amount,1,1,'R');
      // 4
      $fpdf->Cell(47.5,5,'Sales Incentives',1);
      $fpdf->Cell(47.5,5,$pi->incentives,1,0,'R');
      $fpdf->Cell(47.5,5,'Suspension',1);
      $fpdf->Cell(47.5,5,$pi->suspension,1,1,'R');
      // 5
      $fpdf->Cell(47.5,5,'Overtime Pay',1);
      $fpdf->Cell(47.5,5,$pi->overtime_amount,1,0,'R');
      $fpdf->Cell(47.5,5,'Salary Loans',1);
      $fpdf->Cell(47.5,5,$pi->salary_loans,1,1,'R');
      // 6
      $fpdf->Cell(47.5,5,'Perfect Attendance',1);
      $fpdf->Cell(47.5,5,$pi->perfect_attendance,1,0,'R');
      $fpdf->Cell(47.5,5,'SSS / Philhealth / Pagibig',1);
      $fpdf->Cell(47.5,5,$pi->benefits,1,1,'R');
      // 7
      $fpdf->Cell(47.5,5,'Team Perfect Attendance',1);
      $fpdf->Cell(47.5,5,$pi->perfect_attendance_team,1,0,'R');
      $fpdf->Cell(47.5,5,'',1);
      $fpdf->Cell(47.5,5,'',1,1,'R');
      // 8
      $fpdf->Cell(47.5,5,'Holiday Pay',1);
      $fpdf->Cell(47.5,5,$pi->holiday_amount,1,0,'R');
      $fpdf->Cell(47.5,5,'',1);
      $fpdf->Cell(47.5,5,'',1,1,'R');
      // 9
      $fpdf->Cell(47.5,5,'Regularization',1);
      $fpdf->Cell(47.5,5,$pi->regularization,1,0,'R');
      $fpdf->Cell(47.5,5,'',1);
      $fpdf->Cell(47.5,5,'',1,1,'R');
      // 10
      $fpdf->Cell(47.5,5,'One-year Tenureship',1);
      $fpdf->Cell(47.5,5,$pi->one_year,1,0,'R');
      $fpdf->Cell(47.5,5,'',1);
      $fpdf->Cell(47.5,5,'',1,1,'R');
      // 11
      $fpdf->Cell(47.5,5,'Referral',1);
      $fpdf->Cell(47.5,5,$pi->referral,1,0,'R');
      $fpdf->Cell(47.5,5,'',1);
      $fpdf->Cell(47.5,5,'',1,1,'R');
      // 12
      $fpdf->Cell(47.5,5,'Appraisal',1);
      $fpdf->Cell(47.5,5,$pi->appraisal,1,0,'R');
      $fpdf->Cell(47.5,5,'',1);
      $fpdf->Cell(47.5,5,'',1,1,'R');
      // 13
      $fpdf->Cell(47.5,5,'Dispute ',1);
      $fpdf->Cell(47.5,5,$pi->dispute,1,0,'R');
      $fpdf->Cell(47.5,5,'',1);
      $fpdf->Cell(47.5,5,'',1,1,'R');
      // TOTAL
      $fpdf->SetFont('Arial','B',10);
      $fpdf->SetFillColor(184, 204, 228);
      $fpdf->Cell(47.5,5,'Total Earnings',1,0,'R',true);
      $fpdf->SetFillColor(252, 213, 180);
      $fpdf->Cell(47.5,5,$pi->earning_amount,1,0,'R',true);
      $fpdf->SetFillColor(184, 204, 228);
      $fpdf->Cell(47.5,5,'Total Deductions',1,0,'R',true);
      $fpdf->SetFillColor(252, 213, 180);
      $fpdf->Cell(47.5,5,$pi->deduction_amount,1,1,'R',true);
      // CURRENT NET SALARY
      $fpdf->SetFillColor(0,0,0);
      $fpdf->SetTextColor(255,0,0);
      $fpdf->Cell(142.5,6,'Current Net Salary',1,0,'R');
      $fpdf->SetFillColor(250,255,0);
      $fpdf->Cell(47.5,6,$pi->net,1,1,'R',true);


      // RECEIVED BY
      $fpdf->SetFont('Arial','B',10);
      $fpdf->SetFillColor(0,0,0);
      $fpdf->SetTextColor(255,255,255);
      $fpdf->Cell(190,5,'RECEIVED BY',1,1,'C',true);
      // CONTENT
      $fpdf->SetFont('Arial','I',10);
      $fpdf->SetFillColor(255,255,255);
      $fpdf->SetTextColor(0,0,0);
      $fpdf->Cell(190,8,'I acknowledge to have received the amount stated here within with no further claim for services rendered. ',1,1,'C',true);
      $fpdf->SetFont('Arial','',10);
      $fpdf->Cell(95,10,'',1,0,'C');
      $fpdf->Cell(95,10,'',1,1,'C');
      $fpdf->SetFont('Arial','B',10);
      $fpdf->Cell(95,5,'Employee Name & Signature',1,0,'C');
      $fpdf->Cell(95,5,'Date',1,1,'C');

      // APPROVED BY
      $fpdf->SetFont('Arial','B',10);
      $fpdf->SetFillColor(0,0,0);
      $fpdf->SetTextColor(255,255,255);
      $fpdf->Cell(190,5,'APPROVED BY',1,1,'C',true);
      // CONTENT
      $fpdf->SetFillColor(255,255,255);
      $fpdf->SetTextColor(0,0,0);
      $fpdf->Cell(190,13,'',1,1,'C',true);
      $fpdf->SetFont('Arial','B',10);
      $fpdf->Cell(190,5,'KR RIVERO','LR',1,'C',true);
      $fpdf->SetFont('Arial','I',10);
      $fpdf->Cell(190,5,'HR & Finance Manager, The Launchpad, Inc','LRB',1,'C',true);
      $fpdf->Image('signature.png',98,205,15,10);

      $filename = $emp->SearchEmployeeById($pi->emp_id).'-'.$pi->payroll_id.'.pdf';
      // Storage::put('employee/'.$filename, $fpdf->Output('S'));

      $response = response($fpdf->Output($filename, 'I'));
      $response->header('Content-Type', 'application/pdf');

      return $response;

    }

    public function edit($id)
    {
      $payrollitem = PayrollItems::find($id);
      return view('admin.payroll_items.update', compact('payrollitem'));
    }

    public function update(Request $request, $id)
    {
      $payrollitem = PayrollItems::findOrFail($id);
      $result = $payrollitem->update($request->all());
      if ($result)
        return true;
      else
        return false;
    }

    public function destroy($id)
    {
      $payroll = PayrollItems::find($id);
      $payroll->delete();
      return 1;
    }
}
