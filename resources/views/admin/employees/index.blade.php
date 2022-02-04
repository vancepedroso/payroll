@inject('EmployeeModel', 'App\Models\Employee')
@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="custom_table" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Employee ID</th>
                  <th>Full Name</th>
                  <th>Department</th>
                  <th>Position</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($employees as $employee)
                <tr>
                  <td class="text-center">{{ substr($employee->created_at, 0, 4).'-'.sprintf("%04d", $employee->id) }}</td>
                  <td>{{ $employee->first_name.' '.$employee->last_name }}</td>
                  <td>{{ $employee->team_name }}</td>
                  <td>{{ $employee->pos_name }}</td>
                  <td class="text-center"
                  style="{{ $EmployeeModel->SearchEmployeeExist($employee->id) ? '':'border:1px dashed red' }}">
                    <button class="btn btn-sm btn-outline-primary view_employee" data-id="{{ $employee->id }}" type="button"><i class="fa fa-eye"></i></button>
                    <button class="btn btn-sm btn-outline-primary edit_employee" data-id="{{ $employee->id }}" type="button"><i class="fa fa-edit"></i></button>
                    @if ( $EmployeeModel->SearchEmployeeExist($employee->id) == true )
                      <button class="btn btn-sm btn-outline-danger remove_employee" data-id="{{ $EmployeeModel->SearchEmployeeEmpId($employee->id) }}" type="button"><i class="fa fa-trash"></i></button>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
@parent
<script type="text/javascript">

$(document).ready(function(){	

	$(document).on('click','.edit_employee',function(){
    var action = "{{ route('admin.employees.edit',':id') }}";
    var url = action.replace(':id', $(this).attr('data-id'));
		uni_modal("Edit Employee",url,"mid-large")
	});
	$(document).on('click','.view_employee',function(){
    var action = "{{ route('admin.employees.show',':id') }}";
    var url = action.replace(':id', $(this).attr('data-id'));
		uni_modal("Employee Details",url,"mid-large")
	});
	$(document).on('click','.remove_employee',function(){
		_conf("Are you sure to delete some data to this employee?","remove_employee",[$(this).attr('data-id')])
	})
  
});

  function remove_employee(id){
    start_load()
    var action = "{{ route('admin.employees.destroy',':id') }}";
    var url = action.replace(':id', id);

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: url,
      type: 'DELETE',
      data:{
        id: id,
      },
      success:function(resp){
        if(resp==1){
          alert_toast("Employee's data successfully deleted","success")
          setTimeout(function(){
            location.reload()
          },1500)
        }
      }
    })
  }

</script>
@endsection