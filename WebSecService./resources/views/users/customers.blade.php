@extends('layouts.master')
@section('title', 'Customer List')
@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Customer List</h2>
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

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Credits</th>
                            <th>Registration Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>${{ number_format($customer->credits, 2) }}</td>
                                <td>{{ $customer->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('add_credits_form', $customer) }}" class="btn btn-sm btn-success">
                                            <i class="bi bi-plus-circle"></i> Add Credits
                                        </a>

                                        <a href="{{ route('profile', $customer) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> View Profile
                                        </a>

                                        @can('block_users')
                                            @if($customer->state == "blocked")
                                                <a href="{{ route('block_user', $customer) }}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-unlock"></i> Unblock User
                                                </a>
                                            @else
                                                <a href="{{ route('block_user', $customer) }}" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-lock"></i> Block User
                                                </a>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($customers->isEmpty())
                <div class="alert alert-info">
                    No customers registered yet.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
