@extends('layouts.master')
@section('title', 'Edit Book')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit Book</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('books.save', $book->id) }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" name="title" required value="{{ $book->title }}">
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author:</label>
                <input type="text" class="form-control" name="author" required value="{{ $book->author }}">
            </div>
            <div class="mb-3">
                <label for="published_year" class="form-label">Published Year:</label>
                <input type="number" class="form-control" name="published_year" required value="{{ $book->published_year }}">
            </div>
            <button type="submit" class="btn btn-primary">Save Book</button>
        </form>
    </div>
</div>
@endsection
