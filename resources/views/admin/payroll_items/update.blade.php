@inject('PayrollModel', 'App\Models\Payroll')
@inject('EmployeeModel', 'App\Models\Employee')
<div class="container-fluid">

  <form id="payroll_frm" class="form-horizontal" autocomplete="off">

    <input type="hidden" id="id" value="{{ $payrollitem->id }}" disabled>
    <input type="hidden" id="payroll_id" value="{{ $payrollitem->payroll_id }}" disabled>

    <div class="row">

      <div class="col-md-4">
        <div class="card">
          <div class="card-header text-center">
            <span><b>Employee Name : {{ $EmployeeModel->SearchEmployeeById($payrollitem->emp_id) }}</b></span>
          </div>
          <div class="card-body">

            <div class="form-group row">
              <label for="rdot" class="col-sm-6 control-label col-form-label">RDOT Date</label>
              <div class="col-sm-6">
                <input type="date" class="form-control text-right" name="rdot" value="{{ $payrollitem->rdot }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="perfect_attendance_date" class="col-sm-6 control-label col-form-label">Perfect Attendance Date</label>
              <div class="col-sm-6">
                <input type="date" class="form-control text-right" name="perfect_attendance_date" value="{{ $payrollitem->perfect_attendance_date }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="holiday_date" class="col-sm-6 control-label col-form-label">Holiday Date</label>
              <div class="col-sm-6">
                <input type="date" class="form-control text-right" name="holiday_date" value="{{ $payrollitem->holiday_date }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="total_regular_wdays" class="col-sm-7 control-label col-form-label">Regular Work Days</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" name="total_regular_wdays" value="{{ $payrollitem->total_regular_wdays }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="absent" class="col-sm-7 control-label col-form-label">Absent / VL / SL / Suspension</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" name="absent" value="{{ $payrollitem->absent }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="late" class="col-sm-7 control-label col-form-label">Minutes Late</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" name="late" value="{{ $payrollitem->late }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="undertime" class="col-sm-7 control-label col-form-label">Minutes Undertime</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" name="undertime" value="{{ $payrollitem->undertime }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="overtime" class="col-sm-7 control-label col-form-label">Hours Overtime</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" name="overtime" value="{{ $payrollitem->overtime }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="total_wdays" class="col-sm-7 control-label col-form-label">Total Work Days</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" name="total_wdays" value="{{ $payrollitem->total_wdays }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="total_whours" class="col-sm-7 control-label col-form-label">Total Work Hours</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" name="total_whours" value="{{ $payrollitem->total_whours }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="training_days" class="col-sm-7 control-label col-form-label">Training Days</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" name="training_days" value="{{ $payrollitem->training_days }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="training_hours" class="col-sm-7 control-label col-form-label">Training Hours</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" name="training_hours" value="{{ $payrollitem->training_hours }}">
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-header text-center">
            <span><b>Earnings</b></span>
          </div>
          <div class="card-body">

            <div class="form-group row">
              <label for="gross_pay" class="col-sm-7 control-label col-form-label">Gross Pay</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="gross_pay" name="gross_pay" value="{{ $payrollitem->gross_pay }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="allowance" class="col-sm-7 control-label col-form-label">Allowance</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="allowance" name="allowance" value="{{ $payrollitem->allowance }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="night_differential" class="col-sm-7 control-label col-form-label">Night Differential</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="night_differential" name="night_differential" value="{{ $payrollitem->night_differential }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="incentives" class="col-sm-7 control-label col-form-label">Sales Incentives</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="incentives" name="incentives" value="{{ $payrollitem->incentives }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="overtime_amount" class="col-sm-7 control-label col-form-label">Overtime Pay</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="overtime_amount" name="overtime_amount" value="{{ $payrollitem->overtime_amount }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="perfect_attendance" class="col-sm-7 control-label col-form-label">Perfect Attendance</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="perfect_attendance" name="perfect_attendance" value="{{ $payrollitem->perfect_attendance }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="perfect_attendance_team" class="col-sm-7 control-label col-form-label">Team Perfect Attendance</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="perfect_attendance_team" name="perfect_attendance_team" value="{{ $payrollitem->perfect_attendance_team }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="holiday_amount" class="col-sm-7 control-label col-form-label">Holiday Pay</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="holiday_amount" name="holiday_amount" value="{{ $payrollitem->holiday_amount }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="regularization" class="col-sm-7 control-label col-form-label">Regularization</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="regularization" name="regularization" value="{{ $payrollitem->regularization }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="one_year" class="col-sm-7 control-label col-form-label">One-year Tenureship</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="one_year" name="one_year" value="{{ $payrollitem->one_year }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="referral" class="col-sm-7 control-label col-form-label">Referral</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="referral" name="referral" value="{{ $payrollitem->referral }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="appraisal" class="col-sm-7 control-label col-form-label">Appraisal</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="appraisal" name="appraisal" value="{{ $payrollitem->appraisal }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="dispute" class="col-sm-7 control-label col-form-label">Dispute</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="dispute" name="dispute" value="{{ $payrollitem->dispute }}" onchange="AutoCalculations()">
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-4">

        <div class="card">
          <div class="card-header text-center">
            <span><b>Deductions</b></span>
          </div>
          <div class="card-body">

            <div class="form-group row">
              <label for="absent_amount" class="col-sm-7 control-label col-form-label">Absent / LWOP / No Work</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="absent_amount" name="absent_amount" value="{{ $payrollitem->absent_amount }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="late_amount" class="col-sm-7 control-label col-form-label">Late</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="late_amount" name="late_amount" value="{{ $payrollitem->late_amount }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="undertime_amount" class="col-sm-7 control-label col-form-label">Undertime</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="undertime_amount" name="undertime_amount" value="{{ $payrollitem->undertime_amount }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="suspension" class="col-sm-7 control-label col-form-label">Suspension</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="suspension" name="suspension" value="{{ $payrollitem->suspension }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="salary_loans" class="col-sm-7 control-label col-form-label">Salary Loans</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="salary_loans" name="salary_loans" value="{{ $payrollitem->salary_loans }}" onchange="AutoCalculations()">
              </div>
            </div>

            <div class="form-group row">
              <label for="benefits" class="col-sm-7 control-label col-form-label">Benefits</label>
              <div class="col-sm-5">
                <input type="text" class="form-control text-right" id="benefits" name="benefits" value="{{ $payrollitem->benefits }}" onchange="AutoCalculations()">
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>

    <hr class="divider">

    <div class="row">

      <div class="col-md-4">
      </div>

      <div class="col-md-4">
        <div class="form-group row">
          <label for="" class="col-sm-7 control-label col-form-label float-right"><b>Total Earnings</b></label>
          <div class="col-sm-5">
            <input type="text" class="form-control text-right" id="earning_amount" name="earning_amount" value="{{ $payrollitem->earning_amount }}" onchange="AutoCalculations()">
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group row">
          <label for="deduction_amount" class="col-sm-7 control-label col-form-label"><b>Total Deductions</b></label>
          <div class="col-sm-5">
            <input type="text" class="form-control text-right" id="deduction_amount" name="deduction_amount" value="{{ $payrollitem->deduction_amount }}" onchange="AutoCalculations()">
          </div>
        </div>

        <div class="form-group row">
          <label for="net" class="col-sm-7 control-label col-form-label"><b>Net Salary</b></label>
          <div class="col-sm-5">
            <input type="text" class="form-control text-right" style="font-weight: bold;" id="net" name="net" value="{{ $payrollitem->net }}">
          </div>
        </div>
      </div>

    </div>

  </form>

</div>

<script type="text/javascript">
$(document).ready(function(){

  $('#payroll_frm').submit(function(e){
    e.preventDefault()

    start_load();

    var id = $('#id').val();
    var data = new FormData($(this)[0]);
    
    var action = "{{ route('admin.payrollitems.update', ':id') }}";
    var url = action.replace(':id', id);
    data.append('_method','PUT');

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: url,
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      type: 'POST',
      method: 'POST',
      success:function(resp){
        // var action2 = "{{ route('admin.payroll.show',':id') }}";
        // var url2 = action2.replace(':id', $('#payroll_id').val());
        alert_toast("Payroll Item has successfully updated","success")
        end_load()
        // uni_modal("View Payroll",url2,"modal-xl")
      },
      error:function(err){
        alert_toast("Payroll Item update failed","danger");
        end_load()
        console.log(err);
      }
    })

  })

});

function AutoCalculations()
{
  var grosspay = parseFloat($('#gross_pay').val().replace(/,/g, ''));
  var allowance = parseFloat($('#allowance').val().replace(/,/g, ''));
  var night_differential = parseFloat($('#night_differential').val().replace(/,/g, ''));
  var incentives = parseFloat($('#incentives').val().replace(/,/g, ''));
  var overtime_amount = parseFloat($('#overtime_amount').val().replace(/,/g, ''));
  var perfect_attendance = parseFloat($('#perfect_attendance').val().replace(/,/g, ''));
  var perfect_attendance_team = parseFloat($('#perfect_attendance_team').val().replace(/,/g, ''));
  var holiday_amount = parseFloat($('#holiday_amount').val().replace(/,/g, ''));
  var regularization = parseFloat($('#regularization').val().replace(/,/g, ''));
  var one_year = parseFloat($('#one_year').val().replace(/,/g, ''));
  var referral = parseFloat($('#referral').val().replace(/,/g, ''));
  var appraisal = parseFloat($('#appraisal').val().replace(/,/g, ''));
  var dispute = parseFloat($('#dispute').val().replace(/,/g, ''));
  var absent_amount = parseFloat($('#absent_amount').val().replace(/,/g, ''));
  var late_amount = parseFloat($('#late_amount').val().replace(/,/g, ''));
  var undertime_amount = parseFloat($('#undertime_amount').val().replace(/,/g, ''));
  var suspension = parseFloat($('#suspension').val().replace(/,/g, ''));
  var salary_loans = parseFloat($('#salary_loans').val().replace(/,/g, ''));
  var benefits = parseFloat($('#benefits').val().replace(/,/g, ''));

  var earning_amount = grosspay + allowance + night_differential + incentives + overtime_amount +perfect_attendance + perfect_attendance_team + holiday_amount + regularization + one_year + referral + appraisal + dispute;


  $('#earning_amount').val(thousands_separators(roundN(earning_amount,2)));

  var deduction_amount = absent_amount + late_amount + undertime_amount + suspension + salary_loans + benefits;

  $('#deduction_amount').val(thousands_separators(roundN(deduction_amount,2)));

  $('#net').val(thousands_separators(roundN(earning_amount-deduction_amount,2)));
}

function thousands_separators(num)
{
  var num_parts = num.toString().split(".");
  num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  return num_parts.join(".");
}

function roundN(num,n){
  return parseFloat(Math.round(num * Math.pow(10, n)) /Math.pow(10,n)).toFixed(n);
}
</script>