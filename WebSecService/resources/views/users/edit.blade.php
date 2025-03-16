@extends('layouts.master')
@section('title', 'Edit User')
@section('content')
<div class="d-flex justify-content-center">
    <div class="row m-4 col-sm-8">
        <form action="{{ route('users_save', $user->id) }}" method="post">
            {{ csrf_field() }}
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    <strong>Error!</strong> {{$error}}
                </div>
            @endforeach
            <div class="row mb-2">
                <div class="col-12">
                    <label for="code" class="form-label">Name:</label>
                    <input type="text" class="form-control" placeholder="Name" name="name" required value="{{$user->name}}">
                </div>
            </div>
            @if(auth()->id() == $user->id || auth()->user()->hasPermissionTo('edit_users'))
                @can('change_password')
                    <div class="col-12 mb-2">
                        <label for="new_password" class="form-label">New Password:</label>
                        <input type="password" class="form-control" name="new_password" placeholder="New Password">
                    </div>
                    <div class="col-12 mb-2">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password:</label>
                        <input type="password" class="form-control" name="new_password_confirmation" placeholder="Confirm New Password">
                    </div>
                @endcan
            @endif
            @can('edit_users')
                <div class="col-12 mb-2">
                    <label for="roles" class="form-label">Roles:</label>
                    <select name="roles[]" class="form-control" multiple>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $role->taken ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mb-2">
                    <label for="permissions" class="form-label">Permissions:</label>
                    <select name="permissions[]" class="form-control" multiple>
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}" {{ $permission->taken ? 'selected' : '' }}>{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endcan
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
