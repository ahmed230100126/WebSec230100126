@extends('layouts.master')
@section('title', 'Student Transcript')
@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-gradient-primary text-white py-3">
            <h4 class="m-0 font-weight-bold">Student Transcript</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>Course</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transcript as $course => $grade)
                        <tr class="animate__animated animate__fadeIn">
                            <td class="font-weight-bold">{{ $course }}</td>
                            <td>
                                <span class="badge {{ 
                                    substr($grade, 0, 1) === 'A' ? 'bg-success' : 
                                    (substr($grade, 0, 1) === 'B' ? 'bg-primary' : 
                                    (substr($grade, 0, 1) === 'C' ? 'bg-warning' : 
                                    (substr($grade, 0, 1) === 'D' ? 'bg-danger' : 'bg-dark'))) 
                                }} text-white p-2">
                                    {{ $grade }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light">
            <small class="text-muted">Last updated: {{ date('F j, Y') }}</small>
        </div>
    </div>
</div>

@section('styles')
<style>
    .card {
        transition: transform 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .bg-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.1);
    }
</style>
@endsection
@endsection
