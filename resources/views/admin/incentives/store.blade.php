@inject('employees', 'App\Models\Employee')
<form id="incentive_frm" class="form-horizontal" autocomplete="off">
  <div class="form-group row">
    <label for="title" class="col-sm-2 text-right control-label col-form-label">Employee</label>
    <div class="col-sm-10">
      <select class="select2 form-control" name="emp_id" style="height: 36px;width: 100%;" required>
        <option value=""></option>
        @foreach($employees->SearchEmployees() as $employee)
          <option value="{{ $employee->id }}">
            {{ $employee->first_name.' '.$employee->last_name }}
          </option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label for="title" class="col-sm-2 text-right control-label col-form-label">Description</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="desc" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="title" class="col-sm-2 text-right control-label col-form-label">Amount</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" name="amount" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="title" class="col-sm-2 text-right control-label col-form-label">Date From-To</label>
    <div class="col-sm-10">
      <input type="text" class="form-control daterange" name="date_from_to" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="title" class="col-sm-2 text-right control-label col-form-label">Effective Date</label>
    <div class="col-sm-10">
      <input type="text" class="form-control date" name="effective_date" required>
    </div>
  </div>
</form>

<script type="text/javascript">
$(document).ready(function(){ 

  //Date picker
  $('.date').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })

  //Date range picker
  $('.daterange').daterangepicker({
    autoUpdateInput: false,
    locale: {
      format: 'YYYY-MM-DD'
    }
  })

  $('.daterange').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
  })

  $('#incentive_frm').submit(function(e){
    e.preventDefault()
    start_load();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url:"{{ route('admin.incentives.store') }}",
      data:new FormData($(this)[0]),
      cache: false,
      contentType: false,
      processData: false,
      type: 'POST',
      method: 'POST',
      error:err=>console.log(),
      success:function(resp){
        if(resp == 1){
          alert_toast("Incentive has successfully saved","success");
          setTimeout(function(){
            location.reload()
          },1500)
        }
      }
    })
  })

});
</script>