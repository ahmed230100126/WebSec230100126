@extends('layouts.master')
@section('title', 'transcript')
@section('content')
   
<div class="container mt-5">
    <h2 class="text-center">Student Transcript</h2>
    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>Course Name</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
            <tr>
                <td>{{ $course['name'] }}</td>
                <td>{{ $course['grade'] }}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>


    <div class="text-center mt-4">
        <h4><strong>Total GPA: {{ $gpa }}</strong></h4>
    </div>
</div>
@endsection
