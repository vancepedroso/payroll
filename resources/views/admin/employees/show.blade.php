@inject('EmployeeModel', 'App\Models\Employee')
<form id="employee_frm" class="form-horizontal">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table>
            <tr>
              <td>
                <h5><small>Employee ID :</small></h5>
              </td>
              <td>
                <h5><b>{{ substr($employee->created_at, 0, 4).'-'.sprintf('%04d', $employee->id) }}</b></h5>
              </td>
            </tr>
            <tr>
              <td>
                <h5><small>Full Name :</small></h5>
              </td>
              <td>
                <h5><b>{{ ucwords($employee->first_name.' '.$employee->last_name) }}</b></h5>
              </td>
            </tr>
            <tr>
              <td>
                <h5><small>Department :</small></h5>
              </td>
              <td>
                <h5><b>{{ ucwords($employee->team_name) }}</b></h5>
              </td>
            </tr>
            <tr>
              <td>
                <h5><small>Position :</small></h5>
              </td>
              <td>
                <h5><b>{{ ucwords($employee->pos_name) }}</b></h5>
              </td>
            </tr>
          </table>
          <hr class="divider">
          <div class="row">

            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <span><b>Earnings</b></span>
                  <button class="btn btn-primary btn-sm float-right" style="padding: 3px 5px" type="button" id="new_earning" data-id="{{ $employee->id }}"><i class="fa fa-plus"></i></button>
                </div>
                <div class="card-body">
                  <ul class="list-group">
                    @foreach($employee_earnings as $earnings)
                    <li class="list-group-item d-flex justify-content-between align-items-center alist" data-id="{{ $earnings->id }}">
                      <table>
                        <tr>
                          <td><p><small>Earnings : </small></p></td>
                          <td><p><small>{{ $earnings->earning ?: '' }}</small></p></td>
                        </tr>
                        <tr>
                          <td><p><small>Amount : </small></p></td>
                          <td><p><small>{{ $earnings->amount ?: '' }}</small></p></td>
                        </tr>
                        <tr>
                          <td><p><small>Type : </small></p></td>
                          <td><p><small>{{ $EmployeeModel->SearchTypeId($earnings->type) }}</small></p></td>
                        </tr>
                        <!-- Condition if Earning Type is "Once" -->
                        @if( $earnings->type == 3 )
                        <tr>
                          <td><p><small>Effective : </small></p></td>
                          <td><p><small>{{ $earnings->effective_date ? date("M d,Y",strtotime($earnings->effective_date)) : '' }}</small></p></td>
                        </tr>
                        @endif
                      </table>
                      <button class="badge badge-danger badge-pill btn remove_earning" type="button" data-id="{{ $earnings->id }}"><i class="fa fa-trash"></i></button>
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <span><b>Deductions</b></span>
                  <button class="btn btn-primary btn-sm float-right" style="padding: 3px 5px" type="button" id="new_deduction" data-id="{{ $employee->id }}"><i class="fa fa-plus"></i></button>
                </div>
                <div class="card-body">
                  <ul class="list-group">
                    @foreach($employee_deduction as $key => $deductions)
                    <li class="list-group-item d-flex justify-content-between align-items-center dlist" data-id="{{ $deductions->id }}">
                      <table>
                        <tr>
                          <td><p><small>Deduction : </small></p></td>
                          <td><p><small>{{ $deductions->deduction }}</small></p></td>
                        </tr>
                        <tr>
                          <td><p><small>Amount : </small></p></td>
                          <td><p><small>{{ $deductions->amount ?: '' }}</small></p></td>
                        </tr>
                        <tr>
                          <td><p><small>Type : </small></p></td>
                          <td><p><small>{{ $EmployeeModel->SearchTypeId($deductions->type) }}</small></p></td>
                        </tr>
                        <!-- Condition if Deduction Type is "Once" -->
                        @if($deductions->type == 3)
                        <tr>
                          <td><p><small>Effective : </small></p></td>
                          <td><p><small>{{ date("M d,Y",strtotime($deductions->effective_date)) }}</small></p></td>
                        </tr>
                        @endif
                      </table>
                      <button class="badge badge-danger badge-pill btn remove_deduction" type="button"  data-id="{{ $deductions->id }}"><i class="fa fa-trash"></i></button>
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<script type="text/javascript">

  $('#new_earning').click(function(){
    var action = "{{ route('admin.employeeEarnings.show',':id') }}";
    var url = action.replace(':id', $(this).attr('data-id'));
    uni_modal("New Earning for {{ substr($employee->created_at, 0, 4).'-'.sprintf('%04d', $employee->id).' - '.ucwords($employee->first_name.' '.$employee->last_name) }}",url,'mid-large')
  })

  $('#new_deduction').click(function(){
    var action = "{{ route('admin.employeeDeduction.show',':id') }}";
    var url = action.replace(':id', $(this).attr('data-id'));
    uni_modal("New Deduction for {{ substr($employee->created_at, 0, 4).'-'.sprintf('%04d', $employee->id).' - '.ucwords($employee->first_name.' '.$employee->last_name) }}",url,'mid-large')
  })

  $('.remove_earning').click(function(){
    _conf("Are you sure to delete this earning?","remove_earning",[$(this).attr('data-id')])
  })

  $('.remove_deduction').click(function(){
    _conf("Are you sure to delete this deduction?","remove_deduction",[$(this).attr('data-id')])
  })

  function remove_earning(id){
    start_load()
    var action = "{{ route('admin.employeeEarnings.destroy',':id') }}";
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
          alert_toast("Selected earning successfully deleted","success")
          $('.alist[data-id="'+id+'"]').remove()
          $('#confirm_modal').modal('hide')
          end_load()
        }
      }
    })
  }

  function remove_deduction(id){
    start_load()
    var action = "{{ route('admin.employeeDeduction.destroy',':id') }}";
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
          alert_toast("Selected deduction successfully deleted","success")
          $('.dlist[data-id="'+id+'"]').remove()
          $('#confirm_modal').modal('hide')
          end_load()
        }
      }
    })
  }

</script>