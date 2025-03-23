@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-4">Welcome to Our Application</h1>
            <p class="lead mb-4">This is a secure application with role-based access control.</p>
            
            @guest
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 gap-3">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg px-4">Register</a>
                </div>
            @else
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Welcome back, {{ Auth::user()->name }}!</h5>
                        <p class="card-text">You are logged in as a {{ Auth::user()->roles->pluck('name')->join(', ') }}.</p>
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            <a href="{{ route('profile') }}" class="btn btn-primary">View Profile</a>
                            <form action="{{ route('doLogout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</div>
@endsection