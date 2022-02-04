@inject('PayrollModel', 'App\Models\Payroll')
<form id="payroll_frm" class="form-horizontal" autocomplete="off">

  <div class="form-group row">
    <label for="" class="col-sm-3 text-right control-label col-form-label">Ref No : </label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="ref_no" value="{{ date('Y') .'-'. mt_rand(1,9999) }}" readonly >
    </div>
  </div>

  <div class="form-group row">
    <label for="" class="col-sm-3 text-right control-label col-form-label">Department</label>
    <div class="col-sm-9">
      <select class="form-control custom-select browser-default" name="dept_id" required>
        @foreach ($PayrollModel->SearchDepartments() as $department)
          <option value="{{ $department->id }}">{{ $department->team_name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="form-group row">
    <label for="date_from" class="col-sm-3 text-right control-label col-form-label">Date From : </label>
    <div class="col-sm-9">
      <input type="text" class="form-control date" name="date_from" id="date_from" required>
    </div>
  </div>

  <div class="form-group row">
    <label for="date_to" class="col-sm-3 text-right control-label col-form-label">Date To : </label>
    <div class="col-sm-9">
      <input type="text" class="form-control date" name="date_to" id="date_to" required>
    </div>
  </div>

  <div class="form-group row">
    <label for="" class="col-sm-3 text-right control-label col-form-label">Payroll Type : </label>
    <div class="col-sm-9">
      <select class="form-control custom-select browser-default" name="type" required>
        <option value="1">Monthly</option>
        <option value="2" selected>Semi-Monthly</option>
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

    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();

    start_load();

    if (date_from == '') {


      alert_toast("\"Date From\" must not be empty ","error");
      end_load()

    } else if (date_to == '') {

      alert_toast("\"Date To\" must not be empty ","error");
      end_load()

    } else if (date_from > date_to) {

      alert_toast("\"Date From\" must not be greater than \"Date To\"! ","error");
      end_load()

    } else {

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url:"{{ route('admin.payroll.store') }}",
        data:new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        method: 'POST',
        error:err=>console.log(),
        success:function(resp){
          if(resp == 1){
            alert_toast("Payroll has successfully saved","success");
            setTimeout(function(){
              location.reload()
            },1500)
          } else {
            alert_toast("Payroll saving failed!","error");
            end_load()
          }
        }
      })

    }
  })

});
</script>