@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
      View
    </div>

    <div class="card-body">
        <form action="{{ route("admin.permissions.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">Title*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($permission) ? $permission->title : '') }}" required>
                @if($errors->has('title'))
                    <p class="help-block">
                        ID
                    </p>
                @endif
                <p class="helper-block">
                    Permission
                </p>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ url()->previous() }}">Back</a>
                <input class="btn btn-info" type="submit" value="Save">
            </div>
        </form>
    </div>
</div>
@endsection