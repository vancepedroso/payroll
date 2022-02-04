@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        Edit User
    </div>

    <div class="card-body">
        <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name2">Full Name</label>
                <input type="text" id="name2" name="name2" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                @if($errors->has('name2'))
                    <p class="help-block">
                        {{ $errors->first('name2') }}
                    </p>
                @endif
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email2">Email</label>
                <input type="email" id="email2" name="email2" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                @if($errors->has('email2'))
                    <p class="help-block">
                        {{ $errors->first('email2') }}
                    </p>
                @endif
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password2">Password</label>
                <input type="password" id="password2" name="password2" class="form-control" required>
                @if($errors->has('password2'))
                    <p class="help-block">
                        {{ $errors->first('password2') }}
                    </p>
                @endif
            </div>
            <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                <label for="roles2">Roles
                    <span class="btn btn-primary btn-xs select-all">Select All</span>
                    <span class="btn btn-danger btn-xs deselect-all">Deselect All</span></label>
                <select name="roles2[]" id="roles2" class="form-control select2" multiple="multiple" required>
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles2'))
                    <p class="help-block">
                        {{ $errors->first('roles2') }}
                    </p>
                @endif
            </div>
            <div>
                <a class="btn btn-secondary" href="{{ url()->previous() }}">Back</a>
                <input class="btn btn-primary" type="submit" value="Update">
            </div>
        </form>


    </div>
</div>
@endsection