@extends('layouts.master')

@section('title', 'Users Management')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Users Management</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Add New User</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Direct Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($user->getDirectPermissions() as $permission)
                                        <span class="badge bg-info">{{ $permission->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        @can('delete_users')
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection