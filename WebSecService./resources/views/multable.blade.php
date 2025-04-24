@extends('layouts.master')
@section('title', 'Prime Numbers')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
      <div class="card shadow-sm my-4">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Multiplication Table of {{$j}}</h5>
        </div>
        <div class="card-body">
          <table class="table table-striped table-bordered">
            <thead class="bg-light">
              <tr>
                <th>Operation</th>
                <th>Result</th>
              </tr>
            </thead>
            <tbody>
              @foreach (range(1, 10) as $i)
              <tr>
                <td class="fw-medium">{{$i}} × {{$j}}</td>
                <td class="text-primary">{{ $i * $j }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
