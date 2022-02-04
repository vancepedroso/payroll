@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="col-lg-12">
    <div class="row">

      <div class="col-md-4">
        <div class="card">
          <form action="" id="manage-earnings">
            <div class="card">

              <div class="card-body">
                <h4 class="card-title">Earnings Form</h4>
                <input type="hidden" name="id">
                <div class="form-group">
                  <label class="control-label">Earning</label>
                  <textarea name="earning" id="" cols="30" rows="2" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                  <label class="control-label">Description</label>
                  <textarea name="description" id="" cols="30" rows="2" class="form-control"></textarea>
                </div>
              </div>

              <div class="border-top">
                <div class="card-body">
                  <button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
                  <button class="btn btn-sm btn-default col-sm-3" type="button" onclick="_reset()"> Cancel</button>
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
                  <th class="text-center">Earning Information</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @php $i = 1; @endphp
                @foreach ($earnings as $earning)
                <tr>
                  <td class="text-center">{{ $i++ }}</td>
                  <td class="">
                     <p>Name: <b>{{ $earning->earning }}</b></p>
                     <p class="truncate"><small>Description: <b>{{ $earning->description }}</b></small></p>
                  </td>
                  <td class="text-center">
                    <button class="btn btn-sm btn-primary edit_earnings" type="button" data-id="{{ $earning->id }}" data-earning="{{ $earning->earning }}" data-description="{{ $earning->description }}" >Edit</button>
                    <button class="btn btn-sm btn-danger delete_earnings" type="button" data-id="{{ $earning->id }}">Delete</button>
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
    $('#manage-earnings').get(0).reset();
  }
  
  $('#manage-earnings').submit(function(e){
    e.preventDefault()
    start_load()
    var id = $('[name="id"]').val();
    var url = '';
    var data = new FormData($(this)[0]);
    
    if ( !id ) {
      url = "{{ route('admin.earnings.store') }}";
    } else {
      var action = "{{ route('admin.earnings.update', ':id') }}";
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

  $('.edit_earnings').click(function(){
    start_load()
    var cat = $('#manage-earnings')
    cat.get(0).reset()
    cat.find("[name='id']").val($(this).attr('data-id'))
    cat.find("[name='earning']").val($(this).attr('data-earning'))
    cat.find("[name='description']").val($(this).attr('data-description'))
    end_load()
  })

  $('.delete_earnings').click(function(){
    _conf("Are you sure to delete this earning?","delete_earnings",[$(this).attr('data-id')])
  })

  function delete_earnings($id){
    start_load()
    var action = "{{ route('admin.earnings.destroy', ':id') }}";
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