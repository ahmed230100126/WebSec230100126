@extends('layouts.master')
@section('title', 'User Profile')
@section('content')
<div class="d-flex justify-content-center">
    <div class="m-4 col-sm-6">
        <div class="card">
            <div class="card-header">
                <h3>User Profile</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>Name</th>
                        <td>{{$user->name}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$user->email}}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{$user->phone ?? 'Not set'}}</td>
                    </tr>
                    <tr>
                        <th>Roles</th>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary">{{$role->name}}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>Direct Permissions</th>
                        <td>
                            @foreach($permissions as $permission)
                                <span class="badge bg-success">{{ $permission->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </table>

                <div class="mt-3">
                    @if(auth()->id() == $user->id || auth()->user()->hasPermissionTo('edit_users'))
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit Profile</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
