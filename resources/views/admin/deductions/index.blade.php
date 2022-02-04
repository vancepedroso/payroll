@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="col-lg-12">
    <div class="row">

      <div class="col-md-4">
        <div class="card">
          <form action="" id="manage-deductions">
            <div class="card">

              <div class="card-body">
                <h4 class="card-title">Deductions Form</h4>
                <input type="hidden" name="id">
                <div class="form-group">
                  <label class="control-label">Deduction</label>
                  <textarea name="deduction" id="" cols="30" rows="2" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                  <label class="control-label">Description</label>
                  <textarea name="description" id="" cols="30" rows="2" class="form-control"></textarea>
                </div>
              </div>

              <div class="border-top">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
                      <button class="btn btn-sm btn-default col-sm-3" type="button" onclick="_reset()"> Cancel</button>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </form>
        </div>
      </div>

      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Deduction Information</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @php $i = 1; @endphp
                @foreach ($deductions as $deduction)
                <tr>
                  <td class="text-center">{{ $i++ }}</td>
                  <td class="">
                     <p>Name: <b>{{ $deduction->deduction }}</b></p>
                     <p class="truncate"><small>Description: <b>{{ $deduction->description }}</b></small></p>
                  </td>
                  <td class="text-center">
                    <button class="btn btn-sm btn-primary edit_deductions" type="button" data-id="{{ $deduction->id }}" data-deduction="{{ $deduction->deduction }}" data-description="{{ $deduction->description }}" >Edit</button>
                    <button class="btn btn-sm btn-danger delete_deductions" type="button" data-id="{{ $deduction->id }}">Delete</button>
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
<script>
  function _reset(){
    $('[name="id"]').val('');
    $('#manage-deductions').get(0).reset();
  }
  
  $('#manage-deductions').submit(function(e){
    e.preventDefault()
    start_load()
    var id = $('[name="id"]').val();
    var url = '';
    var data = new FormData($(this)[0]);
    
    if ( !id ) {
      url = "{{ route('admin.deductions.store') }}";
    } else {
      var action = "{{ route('admin.deductions.update', ':id') }}";
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
      success:function(resp){
        if (resp==1) {
          alert_toast("Data successfully added",'success')
          setTimeout(function(){
            location.reload()
          },1500)
        } else if (resp==2) {
          alert_toast("Data successfully updated",'success')
          setTimeout(function(){
            location.reload()
          },1500)
        }
      }
    })

  })

  $('.edit_deductions').click(function(){
    start_load()
    var cat = $('#manage-deductions')
    cat.get(0).reset()
    cat.find("[name='id']").val($(this).attr('data-id'))
    cat.find("[name='deduction']").val($(this).attr('data-deduction'))
    cat.find("[name='description']").val($(this).attr('data-description'))
    end_load()
  })

  $('.delete_deductions').click(function(){
    _conf("Are you sure to delete this deduction?","delete_deductions",[$(this).attr('data-id')])
  })

  function delete_deductions($id){
    start_load()
    var action = "{{ route('admin.deductions.destroy', ':id') }}";
    url = action.replace(':id', $id);

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: url,
      type: 'DELETE',
      data:{
        id: $id,
      },
      success:function(resp){
        if(resp==1){
          alert_toast("Data successfully deleted",'success')
          setTimeout(function(){
            location.reload()
          },1500)
        }
      }
    })
  }
</script>
@endsection