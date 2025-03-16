@extends('layouts.master')
@section('title', 'Users')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Users List</h3>
        @can('add_user')
            <a href="{{ route('users.create') }}" class="btn btn-success">Add New User</a>
        @endcan
    </div>
    <div class="card-body">
        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" 
                       placeholder="Search by name or email" 
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            @can('show_users')
                                <a href="{{ route('profile', $user->id) }}" class="btn btn-sm btn-info">View</a>
                            @endcan
                            @if(auth()->id() == $user->id || auth()->user()->can('edit_users'))
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary">Edit</a>
                            @endif
                            @can('delete_user')
                                @if(auth()->id() != $user->id)
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection