@extends('layouts.app')
@section('content')

<div class="card">

    <div class="card-body">
        <form action="{{ route("admin.roles.update", [$role->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">Title*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($role) ? $role->title : '') }}" required>
                @if($errors->has('title'))
                    <p class="help-block">
                        {{ $errors->first('title') }}
                    </p>
                @endif
            </div>
            <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
                <label for="permissions">Permissions*
                    <span class="btn btn-primary btn-xs select-all">Select All</span>
                    <span class="btn btn-warning btn-xs deselect-all">Deselect All</span></label>
                <select id="permissions" name="permissions[]" multiple="multiple" class="form-control select2 custom-select">
                    @foreach($permissions as $id => $permissions)
                        <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>{{ $permissions }}</option>
                    @endforeach
                </select>
                @if($errors->has('permissions'))
                    <p class="help-block">
                        {{ $errors->first('permissions') }}
                    </p>
                @endif
            </div>
            <div class="mt-5">
                <a class="btn btn-primary" href="{{ url()->previous() }}">Back</a>
                <input class="btn btn-info" type="submit" value="Save">
            </div>
        </form>


    </div>
</div>
@endsection