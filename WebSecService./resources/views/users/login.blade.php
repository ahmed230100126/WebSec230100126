@extends('layouts.master')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Login</h4>
                </div>
                <div class="card-body p-4">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif
                    
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('do_login') }}" class="mb-4">
                        @csrf
                        <div class="form-group row mb-3">
                            <label for="email" class="col-md-4 col-form-label">Email Address</label>
                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', session('email')) }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="password" class="col-md-4 col-form-label">Password</label>
                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Login
                                </button>
                                
                                <a href="{{ route('password.request') }}" class="btn btn-link px-0">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted mb-3">Or login with</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('redirectToFacebook') }}" class="btn btn-primary mx-1">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="{{ route('login_with_google') }}" class="btn btn-danger mx-1">
                                <i class="fab fa-google"></i> Google
                            </a>
                            <a href="{{ route('login.github') }}" class="btn btn-dark mx-1">
                                <i class="fab fa-github"></i> GitHub
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
