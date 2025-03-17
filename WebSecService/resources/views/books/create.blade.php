@extends('layouts.master')
@section('title', 'Add Book')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Add New Book</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('books.save') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author:</label>
                <input type="text" class="form-control @error('author') is-invalid @enderror" name="author" required>
                @error('author')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="published_year" class="form-label">Published Year:</label>
                <input type="number" class="form-control @error('published_year') is-invalid @enderror" name="published_year" required>
                @error('published_year')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Add Book</button>
        </form>
    </div>
</div>
@endsection
