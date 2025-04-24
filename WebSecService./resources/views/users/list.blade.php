@extends('layouts.master')
@section('title', 'Users')
@section('content')
<div class="container py-4">
  <div class="card shadow">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h2 class="mb-0">Users</h2>
    </div>
    <div class="card-body">
      @if(session('success'))
        <div class="alert alert-success mb-3">
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger mb-3">
          {{ session('error') }}
        </div>
      @endif

      <form class="mb-4">
        <div class="row align-items-end">
          <div class="col-md-4">
            <div class="form-group">
              <label for="keywords">Search</label>
              <input id="keywords" name="keywords" type="text" class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
            </div>
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-search"></i> Search
            </button>
          </div>
          <div class="col-auto">
            <a href="{{ route('users') }}" class="btn btn-outline-secondary">
              <i class="bi bi-x-circle"></i> Reset 
            </a>
          </div>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="table-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Roles</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
          @foreach($users as $user)
            <tr>
              <td>{{$user->id}}</td>
              <td>{{$user->name}}</td>
              <td>{{$user->email}}</td>
              <td>
              @foreach($user->roles as $role)
                <span class="badge bg-primary">{{$role->name}}</span>
              @endforeach
              </td>
              <td>
                <div class="btn-group" role="group">
                @can('edit_users')
                  <a class="btn btn-sm btn-primary" href='{{route('users_edit', [$user->id])}}'>
                    <i class="bi bi-pencil"></i> Edit
                  </a>
                @endcan
                @can('admin_users')
                  <a class="btn btn-sm btn-info" href='{{route('edit_password', [$user->id])}}'>
                    <i class="bi bi-key"></i> Password
                  </a>
                @endcan
                @can('delete_users')
                  <a class="btn btn-sm btn-danger" href='{{route('users_delete', [$user->id])}}'>
                    <i class="bi bi-trash"></i> Delete
                  </a>
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
