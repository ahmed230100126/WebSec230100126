@extends('layouts.master')

@section('title', 'Create Quiz')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm animate__animated animate__fadeIn">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0 fw-bold text-gradient">Create New Quiz</h3>
                        <a href="{{ route('quizzes.index') }}" class="btn btn-outline-secondary btn-sm hover-lift">
                            <i class="fas fa-arrow-left me-1"></i> Back to Quizzes
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('quizzes.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">Quiz Title</label>
                            <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="Enter a descriptive title for your quiz" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="question" class="form-label fw-bold">Question</label>
                            <textarea class="form-control form-control-lg @error('question') is-invalid @enderror" 
                                      id="question" name="question" rows="4" 
                                      placeholder="Enter your question here" required>{{ old('question') }}</textarea>
                            @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="correct_answer" class="form-label fw-bold">Correct Answer</label>
                            <textarea class="form-control form-control-lg @error('correct_answer') is-invalid @enderror" 
                                      id="correct_answer" name="correct_answer" rows="4" 
                                      placeholder="Enter the correct answer here" required>{{ old('correct_answer') }}</textarea>
                            @error('correct_answer')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm hover-lift">
                                <i class="fas fa-save me-1"></i> Create Quiz
                            </button>
                        </div>
                    </form>
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