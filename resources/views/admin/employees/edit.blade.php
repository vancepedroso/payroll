<form id="employee_frm" class="form-horizontal">
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <input type="hidden" name="emp_id" value="{{ $employee2->id }}">
          <div class="form-group">
            <label>Employee ID</label>
            <input type="text" class="form-control" value="{{ substr($employee2->created_at, 0, 4).'-'.sprintf('%04d', $employee2->id) }}" disabled>
          </div>
          <div class="form-group">
            <label>First Name</label>
            <input type="text" class="form-control" value="{{ $employee2->first_name }}" disabled>
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" class="form-control" value="{{ $employee2->last_name }}" disabled>
          </div>
          <div class="form-group">
            <label>Department</label>
            <input type="text" class="form-control" value="{{ $employee2->team_name }}" disabled>
          </div>
          <div class="form-group">
            <label>Position</label>
            <input type="text" class="form-control" value="{{ $employee2->pos_name }}" disabled>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <input type="hidden" id="main_emp_id" value="{{ $employee->id }}">
          <!-- <div class="form-group">
            <label>Bank Name</label>
            <input type="text" class="form-control" name="bank" value="{{ $employee->bank }}">
          </div> -->
          <div class="form-group">
            <label>Account No.</label>
            <input type="text" class="form-control" name="account" value="{{ $employee->account }}">
          </div>
          <div class="form-group">
            <label>Rate Per Day</label>
            <input type="number" class="form-control" name="rate_per_day" value="{{ $employee->rate_per_day ?: '0.00' }}" step="0.01">
          </div>
          <div class="form-group">
            <label>RDOT Per Day</label>
            <input type="number" class="form-control" name="rdot_per_day" value="{{ $employee->rdot_per_day ?: '0.00' }}" step="0.01">
          </div>
          <!-- <div class="form-group">
            <label>SSS</label>
            <input type="text" class="form-control" name="sss" value="{{ $employee->sss }}">
          </div>
          <div class="form-group">
            <label>Philhealth</label>
            <input type="text" class="form-control" name="philhealth" value="{{ $employee->philhealth }}">
          </div>
          <div class="form-group">
            <label>Pagibig</label>
            <input type="text" class="form-control" name="pagibig" value="{{ $employee->pagibig }}">
          </div> -->
        </div>
      </div>
    </div>
  </div>
</form>

<script type="text/javascript">
$(document).ready(function(){ 

  $('#employee_frm').submit(function(e){
    e.preventDefault()
    start_load()

    var id = $('#main_emp_id').val();
    var url = '';
    var data = new FormData($(this)[0]);
    
    if (!id) {
      url = "{{ route('admin.employees.store') }}";
    } else {
      var action = "{{ route('admin.employees.update', ':id') }}";
      url = action.replace(':id', id);
      data.append('_method','PUT');
    }

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
          alert_toast("Employee's data successfully saved","success")
          setTimeout(function(){
            location.reload()
          },1500)
        } else if (resp==2) {
          alert_toast("Employee's data successfully updated","success")
          setTimeout(function(){
            location.reload()
          },1500)
        }
      }
    })

  })
});
</script>