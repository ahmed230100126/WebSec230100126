@extends('layouts.master')

@section('title', $user->id ? 'Edit User' : 'Add User')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $user->id ? 'Edit User' : 'Add New User' }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ $user->id ? route('users.update', $user->id) : route('users.store') }}">
                        @csrf
                        @if($user->id)
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(!$user->id)
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>
                        @endif

                        @can('edit_users')
                            <div class="mb-3">
                                <label class="form-label">Roles</label>
                                <select multiple class="form-select" name="roles[]">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $role->taken ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Direct Permissions</label>
                                <select multiple class="form-select" name="permissions[]">
                                    @foreach($permissions as $permission)
                                        <option value="{{ $permission->name }}" {{ $permission->taken ? 'selected' : '' }}>
                                            {{ $permission->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endcan

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">{{ $user->id ? 'Update User' : 'Create User' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
