@inject('PayrollModel', 'App\Models\Payroll')
<form id="payroll_frm" class="form-horizontal" autocomplete="off">

  <input type="hidden" id="payroll_id" value="{{ $payroll->id }}" disabled>

  <div class="form-group row">
    <label for="" class="col-sm-3 text-right control-label col-form-label">Ref No : </label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="ref_no" value="{{ $payroll->ref_no }}" readonly >
    </div>
  </div>

  <div class="form-group row">
    <label for="" class="col-sm-3 text-right control-label col-form-label">Department</label>
    <div class="col-sm-9">
      <select class="form-control custom-select browser-default" name="dept_id" required>
        @foreach ($PayrollModel->SearchDepartments() as $department)
          <option value="{{ $department->id }}" {{ $payroll->dept_id == $department->id ? "selected" : "" }}>
            {{ $department->team_name }}
          </option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="form-group row">
    <label for="date_from" class="col-sm-3 text-right control-label col-form-label">Date From : </label>
    <div class="col-sm-9">
      <input type="text" class="form-control date" name="date_from" id="date_from"  value="{{ $payroll->date_from }}" required>
    </div>
  </div>

  <div class="form-group row">
    <label for="date_to" class="col-sm-3 text-right control-label col-form-label">Date To : </label>
    <div class="col-sm-9">
      <input type="text" class="form-control date" name="date_to" id="date_to"  value="{{ $payroll->date_to }}" required>
    </div>
  </div>

  <div class="form-group row">
    <label for="" class="col-sm-3 text-right control-label col-form-label">Payroll Type : </label>
    <div class="col-sm-9">
      <select class="form-control custom-select browser-default" name="type" value="{{ $payroll->type }}" required>
        <option value="1">Monthly</option>
        <option value="2">Semi-Monthly</option>
      </select>
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

  $('#payroll_frm').submit(function(e){
    e.preventDefault()

    start_load();

    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();

    var id = $('#payroll_id').val();
    var data = new FormData($(this)[0]);
    
    var action = "{{ route('admin.payroll.update', ':id') }}";
    var url = action.replace(':id', id);
    data.append('_method','PUT');

    if (date_from > date_to) {

      alert_toast("\"Date From\" must not be greater than \"Date To\"! ","error");
      end_load()

    } else {

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
        error:err=>console.log(),
        success:function(resp){
          if (resp==1) {
            alert_toast("Payroll has successfully updated","success")
            setTimeout(function(){
              location.reload()
            },1500)
          }
        }
      })

    }
  })

});
</script>