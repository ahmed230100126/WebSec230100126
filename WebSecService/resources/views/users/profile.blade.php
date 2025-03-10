@extends('layouts.master')
@section('title', 'Profile')
@section('content')
<div class="container mt-5">
    <h2 class="text-center">Profile</h2>
    <div class="card">
        <div class="card-body">
            <h4>User Information</h4>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone:</strong> {{ $user->phone }}</p>
        </div>
    </div>
    @if(auth()->user()->id == $user->id || auth()->user()->admin)
    <div class="card mt-4">
        <div class="card-body">
            <h4>Change Password</h4>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('updatePassword', $user->id) }}" method="post">
                {{ csrf_field() }}
                <div class="form-group mb-2">
                    <label for="current_password" class="form-label">Current Password:</label>
                    <input type="password" class="form-control" name="current_password" required>
                    @error('current_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label for="new_password" class="form-label">New Password:</label>
                    <input type="password" class="form-control" name="new_password" required>
                    @error('new_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label for="new_password_confirmation" class="form-label">Confirm New Password:</label>
                    <input type="password" class="form-control" name="new_password_confirmation" required>
                </div>
                <div class="form-group mb-2">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
