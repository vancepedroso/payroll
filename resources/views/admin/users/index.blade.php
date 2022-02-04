@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
      @can('user_create')
        <a class="btn btn-primary text-white mb-3" data-toggle="modal" data-target="#add-user"><i class="m-r-10 mdi mdi-plus-circle" ></i>Add User</a>
      @endcan
        <div class="table-responsive">
            <table id="custom_table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Email verified at</th>
                        <th>Roles</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($users as $key => $user)
                    <tr>
                        <td>{{ $user->id ?? '' }}</td>
                        <td>{{ $user->name ?? '' }}</td>
                        <td>{{ $user->email ?? '' }}</td>
                        <td>{{ $user->email_verified_at ? date('M d, Y', strtotime($user->email_verified_at)) : '' }}</td>
                        <td>
                          @foreach($user->roles as $key => $item)
                              <span class="badge badge-pill badge-info">{{ $item->title }}</span>
                          @endforeach
                        </td>
                        <td class="text-center">
                          @can('permission_show')
                              <a class="btn btn-xs btn-primary" href="{{ route('admin.users.show', $user->id) }}">
                                  View
                              </a>
                          @endcan

                          @can('user_edit')
                              <a class="btn btn-info btn-xs" href="{{ route('admin.users.edit', $user->id) }}">Edit
                              </a>
                          @endcan

                          @can('user_delete')
                            <button type="button" id="delete" class="btn btn-danger btn-xs" data-id="{{ $user->id }}" data-toggle="modal" data-target="#delete-user">Delete</button>
                          @endcan
                        </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@include('admin.users.modal', ['model' => 'User'])
@endsection