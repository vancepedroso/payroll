@inject('PayrollModel', 'App\Models\Payroll')
@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <button type="button" class="btn btn-outline-primary mb-3 float-right add_payroll"><i class="m-r-10 mdi mdi-plus-circle"></i> Add Payroll</button>

          <div class="table-responsive">
            <table id="custom_table" class="table table-striped table-bordered">
              <thead>
                <tr class="text-center">
                  <th>Ref No.</th>
                  <th>Department</th>
                  <th>Type</th>
                  <th>Date From</th>
                  <th>Date To</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
             @foreach ($payrolls as $payroll)
              <tr>
                <td>{{ $payroll->ref_no }}</td>
                <td>{{ $PayrollModel->SearchDepartmentsById($payroll->dept_id) }}</td>
                <td>{{ $PayrollModel->SearchTypeId($payroll->type) }}</td>
                <td>{{ date("M d,Y",strtotime($payroll->date_from)) }}</td>
                <td>{{ date("M d,Y",strtotime($payroll->date_to)) }}</td>
                <td class="text-center">
                  <span class="badge badge-{{ $PayrollModel->SearchStatusId($payroll->status)['class'] }}">
                    {{ $PayrollModel->SearchStatusId($payroll->status)['status'] }}
                  </span>
                </td>
                <td class="text-center">
                @if ($PayrollModel->SearchStatusId($payroll->status)['status'] == 'Calculated')
                  <button class="btn btn-sm btn-outline-primary view_payroll" data-id="{{ $payroll->id }}" data-ref="{{ $payroll->ref_no }}" type="button"><i class="fa fa-eye"></i></button>
                @else
                  <button class="btn btn-sm btn-outline-primary calculate_payroll" data-id="{{ $payroll->id }}" type="button">Calculate</button>
                @endif
                  <button class="btn btn-sm btn-outline-primary edit_payroll" data-id="{{ $payroll->id }}" type="button"><i class="fa fa-edit"></i></button>
                  <button class="btn btn-sm btn-outline-danger destroy_payroll" data-id="{{ $payroll->id }}" type="button" data-toggle="modal" data-target="#destroy-incentives"><i class="fa fa-trash"></i></button>
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

  $('.add_payroll').click(function(){
    var url = "{{ route('admin.payroll.create') }}";
    uni_modal("New Payroll",url,"modal-md")
  });

  $('.view_payroll').click(function(){
    var action = "{{ route('admin.payroll.show',':id') }}";
    var url = action.replace(':id', $(this).attr('data-id'));
    uni_modal("View Payroll",url,"modal-xl")
  });

  $('.edit_payroll').click(function(){
    var action = "{{ route('admin.payroll.edit',':id') }}";
    var url = action.replace(':id', $(this).attr('data-id'));
    uni_modal("Edit Payroll",url,"modal-md")
  });

  $('.calculate_payroll').click(function(){
    _conf("Are you sure to calculate this payroll?","calculate_payroll",[$(this).attr('data-id')])
  })

  $('.destroy_payroll').click(function(){
    _conf("Are you sure to delete this payroll?","destroy_payroll",[$(this).attr('data-id')])
  })

});

function calculate_payroll(id){

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
        alert_toast("Payroll has successfully calculated","success");
        setTimeout(function(){
          location.reload()
        },1500)
      } else {
        alert_toast("Payroll calculating failed!","error");
        end_load()
      }
    }
  })

};

function destroy_payroll(id){

  start_load()
  var action = "{{ route('admin.payroll.destroy', ':id') }}";
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
        alert_toast("Payroll data has successfully deleted","success")
        setTimeout(function(){
          location.reload()
        },1500)
      }
    }
  })

};

</script>
@endsection