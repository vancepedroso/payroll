@extends('layouts.app')
@section('content')
<div class="card">

    <div class="card-body">

      @can('permission_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-primary text-white" data-toggle="modal" data-target="#add-permission">
                <i class="m-r-10 mdi mdi-plus-circle"></i>Add Permission
                </a>
            </div>
        </div>
      @endcan

        <div class="table-responsive">

            <table id="custom_table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                      <th>Permission</th>
                      <th class="text-center" style="width: 20%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $key => $permission)
                        <tr data-entry-id="{{ $permission->id }}">
                            <td>
                                {{ $permission->title ?? '' }}
                            </td>
                            <td class="text-center">
                                @can('permission_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.permissions.show', $permission->id) }}">
                                        View
                                    </a>
                                @endcan

                                @can('permission_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.permissions.edit', $permission->id) }}">
                                        Edit
                                    </a>
                                @endcan

                                @can('permission_delete')
                                    <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="{{ $permission->id }}" data-toggle="modal" data-target="#delete-permission">Delete</button>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@include('admin.permissions.modal', ['model' => 'Permission'])
@endsection

@section('scripts')
@parent
<script type="text/javascript">
$(document).ready(function(){

  $(document).on('click','#delete',function(){
    var id = $(this).data('id');
    var url = "{{ route('admin.permissions.destroy', ':id') }}";
    var action = url.replace(':id', id);
    $('#deleteForm').attr('action',action);
  });

});
</script>
@endsection