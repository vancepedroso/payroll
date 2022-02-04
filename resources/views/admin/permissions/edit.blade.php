@extends('layouts.app')
@section('content')
<div class="card">

    <div class="card-body">
        <form action="{{ route("admin.permissions.update", [$permission->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">Permission</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($permission) ? $permission->title : '') }}" required>
                @if($errors->has('title'))
                    <p class="help-block">
                        {{ $errors->first('title') }}
                    </p>
                @endif
            </div>
            <div>
                <a class="btn btn-primary" href="{{ url()->previous() }}">Back</a>
                <input class="btn btn-info" type="submit" value="Update">
            </div>
        </form>
    </div>

</div>
@endsection