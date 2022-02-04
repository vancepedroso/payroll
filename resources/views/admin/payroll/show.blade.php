@inject('PayrollModel', 'App\Models\Payroll')
@inject('EmployeeModel', 'App\Models\Employee')
<button type="button" class="btn btn-outline-primary mb-3 float-right calculate_payroll" data-id="{{ $payroll->id }}">
  <i class="m-r-10 mdi mdi-reload"></i>Re-Calculate Payroll
</button>
<input type="hidden" id="payroll_id" value="{{ $payroll->id }}">
<div class="row mb-4">
  <div class="col-md-12">
    <table>
      <tr>
        <td><b>Payroll Ref No : </b></td>
        <td>
          {{ $payroll->ref_no }}
        </td>
      </tr>
      <tr>
        <td><b>Payroll Range: </b></td>
        <td>
          {{ date("M d, Y",strtotime($payroll->date_from)). " - ".date("M d, Y",strtotime($payroll->date_to)) }}
        </td>
      </tr>
      <tr>
        <td><b>Payroll Type: </b></td>
        <td>{{ $PayrollModel->SearchTypeId($payroll->type) }}</td>
      </tr>
      <tr>
        <td><b>Department: </b></td>
        <td>{{ $PayrollModel->SearchDepartmentsById($payroll->dept_id) }}</td>
      </tr>
    </table>
  </div>
</div>
<div class="table-responsive">
  <table id="payroll_table" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Employee ID</th>
        <th>Full Name</th>
        <th>Present</th>
        <th>Absent</th>
        <th>Late</th>
        <th>Undertime</th>
        <th>Total Earnings</th>
        <th>Total Deductions</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($payrollItems as $payrollItem)
      <tr>
        <td class="text-center">{{ $EmployeeModel->SearchEmployeeId($payrollItem->emp_id) }}</td>
        <td>{{ $EmployeeModel->SearchEmployeeById($payrollItem->emp_id) }}</td>
        <td>{{ $payrollItem->present }}</td>
        <td>{{ $payrollItem->absent }}</td>
        <td>{{ $payrollItem->late }}</td>
        <td>{{ $payrollItem->undertime }}</td>
        <td>{{ $payrollItem->earning_amount }}</td>
        <td>{{ $payrollItem->deduction_amount }}</td>
        <td class="text-center">
          <a class="btn btn-sm btn-outline-warning view_payrollitem" data-id="{{ $payrollItem->id }}" type="button" target="_blank" href="{{ route('admin.payrollitems.show',$payrollItem->id) }}"><i class="icofont-file-pdf" style="color:orange"></i></a>
          <button class="btn btn-sm btn-outline-primary edit_payrollitem" data-id="{{ $payrollItem->id }}" type="button"><i class="fa fa-edit"></i></button>
          <button class="btn btn-sm btn-outline-danger destroy_payrollitem" data-id="{{ $payrollItem->id }}"s type="button"><i class="fa fa-trash"></i></button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<script type="text/javascript">
$(document).ready(function(){ 

  var table = $('#payroll_table').DataTable({
    colReorder: true,
    buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
  });
  table.buttons().container().appendTo($('.col-md-6:eq(0)', table.table().container() ));

  $(document).on('click','.edit_payrollitem',function(){
    var action = "{{ route('admin.payrollitems.edit',':id') }}";
    var url = action.replace(':id', $(this).attr('data-id'));
    end_load();
    uni_modal("Edit Payroll Item",url,"modal-xl");
  });

  $(document).on('click','.destroy_payrollitem',function(){
    _conf("Are you sure to delete this payroll item?","destroy_payrollitem",[$(this).attr('data-id')])
  });

  $(document).on('click','.calculate_payroll',function(){
    _conf("Are you sure to recalculate this whole payroll?","recalculate_payroll",[$(this).attr('data-id'),$(this).attr('data-id2')])
  })

});

function recalculate_payroll(id) {

  start_load()
  var action = "{{ route('admin.payroll.calculate', ':id') }}";
  var url = action.replace(':id', id);

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url:url,
    type: 'POST',
    method: 'POST',
    error:err=>console.log(),
    success:function(resp){
      // alert(resp);
      if(resp == 1){
        var action = "{{ route('admin.payroll.show',':id') }}";
        var url = action.replace(':id', id);
        alert_toast("Payroll has successfully recalculated","success");
        end_load()
        $("#confirm_modal").modal('hide');
        uni_modal("View Payroll",url,"modal-xl")
      } else {
        alert_toast("Payroll recalculating failed!","error");
        end_load()
      }
    }
  })

}

function destroy_payrollitem(id){

  start_load()
  var action = "{{ route('admin.payrollitems.destroy', ':id') }}";
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
    error:err=>console.log(),
    success:function(resp){
      if(resp==1){
        var action2 = "{{ route('admin.payroll.show',':id') }}";
        var url2 = action2.replace(':id', $('#payroll_id').val());
        alert_toast("Payroll Item has successfully deleted","success");
        end_load();
        $("#confirm_modal").modal('hide');
        uni_modal("View Payroll",url2,"modal-xl")
      } else {
        alert_toast("Payroll deletion failed!","error");
        end_load()
      }
    }
  })

};
</script>