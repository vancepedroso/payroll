@inject('employees', 'App\Models\Employee')
@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <button type="button" class="btn btn-outline-primary mb-3 float-right add_incentives"><i class="m-r-10 mdi mdi-plus-circle"></i> Add Incentives</button>

          <div class="table-responsive">
            <table id="custom_table" class="table table-striped table-bordered">
              <thead>
                <tr class="text-center">
                  <th>Employee</th>
                  <th>Description</th>
                  <th>Amount</th>
                  <th>Date Range</th>
                  <th>Effective Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($incentives as $incentive)
                <tr>
                  <td class="text-center">
                    {{ $incentive->emp_id ? $employees->SearchEmployeeById($incentive->emp_id) : '' }}
                  </td>
                  <td>{{ $incentive->desc }}</td>
                  <td>{{ $incentive->amount }}</td>
                  <td>{{ date('M d, Y', strtotime(substr($incentive->date_from_to,0,10))).' - '.
                    date('M d, Y', strtotime(substr($incentive->date_from_to,13))) }}</td>
                  <td>{{ date('M d, Y', strtotime($incentive->effective_date)) }}</td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary edit_incentives" data-id="{{ $incentive->id }}" type="button"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-sm btn-outline-danger destroy_incentives" data-id="{{ $incentive->id }}" type="button" data-toggle="modal" data-target="#destroy-incentives"><i class="fa fa-trash"></i></button>
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

  $(document).on('click','.add_incentives',function(){
    var url = "{{ route('admin.incentives.create') }}";
    uni_modal("Add Incentives",url,"modal-md")
  });

  $(document).on('click','.edit_incentives',function(){
    var action = "{{ route('admin.incentives.edit',':id') }}";
    var url = action.replace(':id', $(this).attr('data-id'));
    uni_modal("Edit Incentives",url,"modal-md")
  });

  $(document).on('click','.destroy_incentives',function(){
    _conf("Are you sure to delete this incentive?","destroy_incentive",[$(this).attr('data-id')])
  })

});

function destroy_incentive(id){

  start_load()
  var action = "{{ route('admin.incentives.destroy', ':id') }}";
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
        alert_toast("Incentive data has successfully deleted","success")
        setTimeout(function(){
          location.reload()
        },1500)
      }
    }
  })

};

</script>
@endsection