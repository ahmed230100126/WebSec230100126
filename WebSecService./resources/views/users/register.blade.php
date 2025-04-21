@extends('layouts.master')
@section('title', 'Register')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Create Account</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{route('do_register')}}" method="post">
                        {{ csrf_field() }}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <strong><i class="fas fa-exclamation-circle me-2"></i>Error!</strong> 
                                Registration failed. Please check your information and try again.
                            </div>
                        @endif

                        <div class="form-group mb-3">
                            <label for="name" class="form-label fw-bold">Name</label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   placeholder="Enter your full name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input type="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   placeholder="Enter your email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" 
                                   class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   placeholder="Create a password" 
                                   name="password" 
                                   required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                            <input type="password" 
                                   class="form-control form-control-lg" 
                                   placeholder="Confirm your password" 
                                   name="password_confirmation" 
                                   required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Create Account</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    Already have an account? <a href="{{ route('login') }}" class="text-primary text-decoration-none">Sign in</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
