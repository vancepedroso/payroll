@inject('user', 'App\Models\User')
@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">

          <div class="card">
              <div class="card-body">

                @can('clear_logs')
                <div style="margin-bottom: 10px;" class="row">
                  <div class="col-lg-12">
                    <a class="btn btn-danger" href="{{ route('admin.logs.massDestroy') }}">Clear Logs</a>
                  </div>
                </div>
                @endcan

                <div class="table-responsive">
                  <table id="custom_table" class="table table-bordered table-striped table-hover datatable">
                    <thead>
                      <th>Date</th>
                      <th>Actions</th>
                      <th>User</th>
                    </thead>
                    <tbody>
                      @foreach ($logs as $log)
                        <tr>
                          <td field-key='id'>{{ $log->created_at->format('M d, Y (D) h:i:s a') }}</td>
                          <td field-key='action'>{{ $log->action }}</td>
                          <td field-key='user_id'>{{ $user->SearchEmployeeName($log->user_id) }}</td>
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
</div>
@endsection