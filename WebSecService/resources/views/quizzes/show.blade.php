@extends('layouts.master')

@section('title', $quiz->title)

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4 animate__animated animate__fadeIn">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-1 fw-bold text-gradient">{{ $quiz->title }}</h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-user-tie me-1"></i> {{ $quiz->instructor->name }}
                            </p>
                        </div>
                        <a href="{{ route('quizzes.index') }}" class="btn btn-outline-secondary btn-sm hover-lift">
                            <i class="fas fa-arrow-left me-1"></i> Back to Quizzes
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4 animate__animated animate__fadeInUp">
                        <h5 class="text-primary mb-3 fw-bold">Question:</h5>
                        <div class="p-4 bg-light rounded-3 question-box">
                            {{ $quiz->question }}
                        </div>
                    </div>

                    @if(auth()->user()->hasRole('Student'))
                        @if(!$submission)
                            <form action="{{ route('quizzes.submit', $quiz) }}" method="POST" class="needs-validation animate__animated animate__fadeInUp" novalidate>
                                @csrf
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3 fw-bold">Your Answer:</h5>
                                    <textarea class="form-control form-control-lg @error('answer') is-invalid @enderror" 
                                              id="answer" name="answer" rows="4" 
                                              placeholder="Enter your answer here" required>{{ old('answer') }}</textarea>
                                    @error('answer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary btn-lg shadow-sm hover-lift">
                                        <i class="fas fa-paper-plane me-1"></i> Submit Answer
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-info animate__animated animate__fadeInUp">
                                <h5 class="alert-heading mb-3 fw-bold">Your Submission</h5>
                                <div class="p-4 bg-white rounded-3 submission-box mb-3">
                                    {{ $submission->answer }}
                                </div>
                                @if($submission->status === 'graded')
                                    <div class="mt-3">
                                        <h6 class="mb-2 fw-bold">Score: <span class="badge bg-success rounded-pill px-3 py-2">{{ $submission->score }}/100</span></h6>
                                        @if($submission->feedback)
                                            <div class="mt-2">
                                                <h6 class="mb-2 fw-bold">Feedback:</h6>
                                                <div class="p-3 bg-white rounded-3 feedback-box">
                                                    {{ $submission->feedback }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="mt-3">
                                        <span class="badge bg-warning rounded-pill px-3 py-2">Pending Review</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @else
                        <div class="mb-4 animate__animated animate__fadeInUp">
                            <h5 class="text-primary mb-3 fw-bold">Correct Answer:</h5>
                            <div class="p-4 bg-light rounded-3 answer-box">
                                {{ $quiz->correct_answer }}
                            </div>
                        </div>

                        @if($submissions->count() > 0)
                            <div class="mt-4">
                                <h5 class="text-primary mb-3 fw-bold">Student Submissions</h5>
                                @foreach($submissions as $submission)
                                    <div class="card mb-3 shadow-sm hover-lift animate__animated animate__fadeInUp">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0 fw-bold">
                                                    <i class="fas fa-user me-2"></i>{{ $submission->student->name }}
                                                </h6>
                                                @if($submission->status === 'graded')
                                                    <span class="badge bg-success rounded-pill px-3 py-2">Graded</span>
                                                @else
                                                    <span class="badge bg-warning rounded-pill px-3 py-2">Pending</span>
                                                @endif
                                            </div>
                                            <div class="p-4 bg-light rounded-3 submission-box mb-3">
                                                {{ $submission->answer }}
                                            </div>
                                            @if($submission->status === 'graded')
                                                <div class="mt-3">
                                                    <h6 class="mb-2 fw-bold">Score: <span class="badge bg-success rounded-pill px-3 py-2">{{ $submission->score }}/100</span></h6>
                                                    @if($submission->feedback)
                                                        <div class="mt-2">
                                                            <h6 class="mb-2 fw-bold">Feedback:</h6>
                                                            <div class="p-3 bg-white rounded-3 feedback-box">
                                                                {{ $submission->feedback }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <form action="{{ route('quizzes.grade', [$quiz, $submission]) }}" method="POST" class="needs-validation" novalidate>
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="score" class="form-label fw-bold">Score (0-100)</label>
                                                        <input type="number" class="form-control form-control-lg @error('score') is-invalid @enderror" 
                                                               id="score" name="score" min="0" max="100" required>
                                                        @error('score')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="feedback" class="form-label fw-bold">Feedback</label>
                                                        <textarea class="form-control form-control-lg @error('feedback') is-invalid @enderror" 
                                                                  id="feedback" name="feedback" rows="3" 
                                                                  placeholder="Enter feedback for the student">{{ old('feedback') }}</textarea>
                                                        @error('feedback')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary btn-lg shadow-sm hover-lift">
                                                            <i class="fas fa-check me-1"></i> Grade Submission
                                                        </button>
                                                    </div>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info animate__animated animate__fadeIn">
                                <i class="fas fa-info-circle me-2"></i>No submissions yet.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
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
    border-radius: 15px;
}

.card:hover {
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.form-control {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: #2196F3;
    box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
}

.btn {
    transition: all 0.2s ease;
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
}

.btn-primary {
    background: linear-gradient(45deg, #2196F3, #00BCD4);
    border: none;
}

.btn-outline-secondary {
    border-width: 2px;
}

.form-label {
    color: #495057;
    margin-bottom: 0.5rem;
}

.invalid-feedback {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.question-box, .answer-box, .submission-box, .feedback-box {
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: all 0.2s ease;
}

.question-box:hover, .answer-box:hover, .submission-box:hover, .feedback-box:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.badge {
    font-weight: 500;
    letter-spacing: 0.5px;
}

.alert {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
</style>

<script>
// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>
@endsection 