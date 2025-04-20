@extends('layouts.master')

@section('title', 'Registration Status')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Registration Status</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                            
                            @if (session('email'))
                                <form method="POST" action="{{ route('resend.verification') }}" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ session('email') }}">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">
                                            Request verification email
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    @endif
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="btn btn-link">Go to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
