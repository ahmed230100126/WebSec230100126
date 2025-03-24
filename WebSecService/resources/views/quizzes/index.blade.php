@extends('layouts.master')

@section('title', 'Quizzes')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
        <div>
            <h2 class="mb-1 fw-bold text-gradient">Quizzes</h2>
            <p class="text-muted">Manage and take quizzes</p>
        </div>
        @can('add_quizzes')
        <a href="{{ route('quizzes.create') }}" class="btn btn-primary btn-lg shadow-sm hover-lift">
            <i class="fas fa-plus"></i> Create New Quiz
        </a>
        @endcan
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        @forelse($quizzes as $quiz)
        <div class="col-md-6 mb-4 animate__animated animate__fadeInUp">
            <div class="card h-100 shadow-sm hover-lift">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">{{ $quiz->title }}</h5>
                        @if(auth()->user()->hasRole('Student'))
                            @if($quiz->hasSubmissionFromStudent(auth()->id()))
                                <span class="badge bg-info rounded-pill px-3 py-2">Submitted</span>
                            @else
                                <span class="badge bg-success rounded-pill px-3 py-2">Available</span>
                            @endif
                        @else
                            <span class="badge bg-{{ $quiz->is_active ? 'success' : 'danger' }} rounded-pill px-3 py-2">
                                {{ $quiz->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted">{{ Str::limit($quiz->question, 150) }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small">
                            <i class="fas fa-user-tie me-1"></i> {{ $quiz->instructor->name }}
                        </div>
                        <div>
                            <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-sm btn-outline-primary hover-lift">
                                <i class="fas fa-eye me-1"></i> View Details
                            </a>
                            @can('delete_quizzes')
                            <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger hover-lift" 
                                        onclick="return confirm('Are you sure you want to delete this quiz?')">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 animate__animated animate__fadeIn">
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-question-circle fa-3x text-gradient mb-3"></i>
                    <h5 class="text-muted">No quizzes available</h5>
                    @can('add_quizzes')
                    <p class="text-muted">Create your first quiz to get started!</p>
                    <a href="{{ route('quizzes.create') }}" class="btn btn-primary btn-lg shadow-sm hover-lift">
                        <i class="fas fa-plus"></i> Create New Quiz
                    </a>
                    @endcan
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
.text-gradient {
    background: linear-gradient(45deg, #2196F3, #00BCD4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hover-lift {
    transition: transform 0.2s ease-in-out;
}

.hover-lift:hover {
    transform: translateY(-5px);
}

.card {
    transition: all 0.3s ease;
    border: none;
}

.card:hover {
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.badge {
    font-weight: 500;
    letter-spacing: 0.5px;
}

.btn {
    transition: all 0.2s ease;
    border-radius: 8px;
}

.btn-primary {
    background: linear-gradient(45deg, #2196F3, #00BCD4);
    border: none;
}

.btn-outline-primary {
    border-width: 2px;
}

.btn-outline-danger {
    border-width: 2px;
}
</style>
@endsection 