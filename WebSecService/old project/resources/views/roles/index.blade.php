@extends('layouts.master')
@section('title', 'Roles Management')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Roles Management</h3>
        <a href="{{ route('roles.create') }}" class="btn btn-success">Add New Role</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            @foreach($role->permissions as $permission)
                                <span class="badge bg-primary">{{ $permission->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection