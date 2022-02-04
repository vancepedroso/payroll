@inject('DeductionsModel', 'App\Models\Deduction')
<div class="container-fluid">
  <form id="employee-deduction">
    <input type="hidden" id="emp_id" name="emp_id" value="{{ $emp_id }}">
    <div class="row form-group">
      <div class="col-md-4">
        <label for="" class="control-label">Deductions</label>
        <select id="deduction_id" class="custom-select" required>
          @foreach($DeductionsModel->SearchDeductions() as $deductions)
            <option value="{{ $deductions->id }}">{{ $deductions->deduction }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label for="" class="control-label">Type</label>
        <select id="type" class="custom-select" required>
          <option value="1">Monthly</option>
          <option value="2" selected>Semi-Monthly</option>
          <option value="3">Once</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="" class="control-label">Amount</label>
        <input type="number" id="amount" class="form-control text-right" step="any" required>
      </div>  
    </div>

    <div class="row form-group">
      <div class="col-md-4" style="display: none" id="dfield">
        <label for="" class="control-label">Effective Date</label>
        <input type="date" id="effective_date" class="form-control">
      </div>
      <div class="col-md-4 offset-md-8">
        <label for="" class="control-label">&nbsp</label>
        <button class="btn btn-primary btn-block btn-sm" type="button" id="add_list"> Add to List</button>
      </div>  
    </div>
    <hr>
    <div class="row">
      <table class="table table-striped table-bordered" id="deduction-list">
        <thead>
          <tr>
            <th class="text-center">
              Deductions
            </th>
            <th class="text-center">
              Type
            </th>
            <th class="text-center">
              Amount
            </th>
            <th class="text-center">
              Date
            </th>
            <th class="text-center">
              Action
            </th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </form>
</div>

<div id="tr_clone" style="display: none">
  <table>
    <tr>
      <td>
        <input type="hidden" name="deduction_id[]">
        <p class="deduction"></p>
      </td>
      <td>
        <input type="hidden" name="type[]">
        <p class="type"></p>
      </td>
      <td>
        <input type="hidden" name="amount[]">
        <p class="amount"></p>
      </td>
      <td>
        <input type="hidden" name="effective_date[]">
        <p class="effective_date"></p>
      </td>
      <td class="text-center">
        <button class="btn btn-sm btn-outline-danger" type="button" onclick="$(this).closest('tr').remove()"><i class="fa fa-trash"></i></button>
      </td>
    </tr>
  </table>
</div>

<script type="text/javascript">
$(document).ready(function(){

  $('#type').change(function(){
    if($(this).val() == 3){
      $('#dfield').show()
    }else{
      $('#dfield').hide()
    }
  })

  $('#add_list').click(function(){
    var deduction_id = $('#deduction_id').val(),
        type = $('#type').val(),
        amount = $('#amount').val(),
        effective_date = $('#effective_date').val();

    var tr = $('#tr_clone tr').clone()
    tr.find('[name="deduction_id[]"]').val(deduction_id)
    tr.find('[name="type[]"]').val(type)
    tr.find('[name="effective_date[]"]').val(effective_date)
    tr.find('[name="amount[]"]').val(amount)
    tr.find('.deduction').html($('#deduction_id option[value="'+deduction_id+'"]').html())
    tr.find('.type').html($('#type option[value="'+type+'"]').html())
    tr.find('.amount').html(amount)
    tr.find('.effective_date').html(effective_date)
    $('#deduction-list tbody').append(tr)
    // $('#deduction_id').val('').select2({
    //   placeholder:"Select here",
    //   width:"100%"
    // })
    // $('#type').val('')
    // $('#amount').val('')
    $('#effective_date').val('')
  })

  $('#employee-deduction').submit(function(e){
    e.preventDefault()
    start_load();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url:"{{ route('admin.employeeDeduction.store') }}",
      data:new FormData($(this)[0]),
      cache: false,
      contentType: false,
      processData: false,
      type: 'POST',
      method: 'POST',
      error:err=>console.log(),
      success:function(resp){
        if(resp == 1){
          var action = "{{ route('admin.employees.show',':id') }}";
          var url2 = action.replace(':id', $('#emp_id').val());
          alert_toast("Employee's data successfully saved","success");
          end_load()
          uni_modal("Employee Details",url2,'mid-large')
        }
      }
    })
  })

})
</script>