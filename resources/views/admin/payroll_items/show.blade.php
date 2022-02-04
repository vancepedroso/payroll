@inject('PayrollModel', 'App\Models\Payroll')
@inject('EmployeeModel', 'App\Models\Employee')
<div class="container-fluid">
  
  <div class="row">

    <div class="col-md-4">
      <table>
        <tr>
          <td><h6> Employee ID </h6></td>
          <td>
            <h6>: {{ $EmployeeModel->SearchEmployeeId($payrollitem->emp_id) }}</h6>
          </td>
        </tr>
        <tr>
          <td><h6> Name </h6></td>
          <td>
            <h6>: {{ $EmployeeModel->SearchEmployeeById($payrollitem->emp_id) }}</h6>
          </td>
        </tr>
      </table>
    </div>

    <div class="col-md-4">

      <div class="card">
        <div class="card-header">
          <span><b>Earnings</b></span>
        </div>
        <div class="card-body">
          <ul class="list-group">
            @php $arr_earnings = json_decode($payrollitem->earnings); @endphp
            @foreach( $arr_earnings as $k => $val )
            <li class="list-group-item d-flex justify-content-between align-items-center">
              {{ $PayrollModel->SearchEarningById($val->eid) }}
              <span class="badge badge-primary badge-pill">{{ number_format($val->amount,2) }}</span>
              <!-- <button class="badge badge-danger badge-pill btn remove_earning" data-id="{{ $val->eid }}"><i class="fa fa-trash"></i></button> -->
            </li>
            @endforeach
            <li class="list-group-item d-flex justify-content-between align-items-center">
              Incentives
              <span class="badge badge-primary badge-pill">{{ $payrollitem->incentives }}</span>
            </li>
          </ul>
        </div>
      </div>

    </div>

    <div class="col-md-4">

      <div class="card">
        <div class="card-header">
          <span><b>Deductions</b></span>
        </div>
        <div class="card-body">
          <ul class="list-group">
            @php $arr_deductions = json_decode($payrollitem->deductions); @endphp
            @foreach($arr_deductions as $k => $val)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              {{ $PayrollModel->SearchDeductionById($val->did) }}
              <span class="badge badge-primary badge-pill">{{ number_format($val->amount,2) }}</span>
              <!-- <button class="badge badge-danger badge-pill btn remove_deduction" class="remove_deduction" data-id="{{ $val->did }}"><i class="fa fa-trash"></i></button> -->
            </li>
            @endforeach
          </ul>
        </div>
      </div>

    </div>

  </div>

</div>

<hr class="divider">

<form id="payroll_frm" class="form-horizontal" autocomplete="off">

  <input type="hidden" id="id" value="{{ $payrollitem->id }}" disabled>
  <input type="hidden" id="payroll_id" value="{{ $payrollitem->payroll_id }}" disabled>

  <div class="row">

    <div class="col-md-4">

      <div class="form-group row">
        <label for="" class="col-sm-8 text-right control-label col-form-label">Present</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" style="direction: rtl;" name="present" value="{{ $payrollitem->present }}">
        </div>
      </div>

      <div class="form-group row">
        <label for="" class="col-sm-8 text-right control-label col-form-label">Absent</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" style="direction: rtl;" name="absent" value="{{ $payrollitem->absent }}">
        </div>
      </div>

    </div>

    <div class="col-md-4">

      <div class="form-group row">
        <label for="" class="col-sm-8 text-right control-label col-form-label float-right">Total Earnings</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" style="direction: rtl;" name="earning_amount" value="{{ $payrollitem->earning_amount }}">
        </div>
      </div>

    </div>

    <div class="col-md-4">

      <div class="form-group row">
        <label for="" class="col-sm-8 text-right control-label col-form-label">Late</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" style="direction: rtl;" name="late" value="{{ $payrollitem->late }}">
        </div>
      </div>

      <div class="form-group row">
        <label for="" class="col-sm-8 text-right control-label col-form-label">Undertime</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" style="direction: rtl;" name="undertime" value="{{ $payrollitem->undertime }}">
        </div>
      </div>

      <div class="form-group row">
        <label for="" class="col-sm-8 text-right control-label col-form-label">Total Deductions</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" style="direction: rtl;" name="deduction_amount" value="{{ $payrollitem->deduction_amount }}">
        </div>
      </div>

      <hr class="divider">

      <div class="form-group row">
        <label for="" class="col-sm-8 text-right control-label col-form-label">Net</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" style="font-weight: bold;" name="net" value="{{ $payrollitem->net }}">
        </div>
      </div>

    </div>

  </div>

</form>

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
        var action2 = "{{ route('admin.payroll.show',':id') }}";
        var url2 = action2.replace(':id', $('#payroll_id').val());
        alert_toast("Payroll Item has successfully updated","success")
        end_load()
        uni_modal("View Payroll",url2,"modal-xl")
      },
      error:function(err){
        alert_toast("Payroll Item update failed","danger");
        end_load()
        console.log(err);
      }
    })

  })

});
</script>