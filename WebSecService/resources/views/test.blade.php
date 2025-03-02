@extends('layouts.master')
@section('title', 'book')
@section('content')
<div class="card">
    <div class="card-header">
      test URI requst 
    </div>
    <div class="card-body">
      <blockquote class="blockquote mb-0">
        <p > you are choese is {{$this_id}}</p>
      </blockquote>
    </div>
  </div>
  @endsection

  