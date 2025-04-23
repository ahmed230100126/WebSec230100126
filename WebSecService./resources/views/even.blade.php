@extends('layouts.master')
@section('title', 'Even Numbers')
@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
        <div class="card-header bg-gradient-info text-white py-3">
            <h4 class="m-0 font-weight-bold">Even Numbers</h4>
        </div>
        <div class="card-body">
            <div class="row">
                @for ($i = 0; $i <= 20; $i++)
                    @if ($i % 2 == 0)
                        <div class="col-md-3 col-sm-4 col-6 mb-3">
                            <div class="number-box d-flex justify-content-center align-items-center py-3 rounded">
                                <span class="h4 mb-0">{{ $i }}</span>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
            
            <div class="alert alert-info mt-4">
                <i class="fas fa-info-circle mr-2"></i>
                Even numbers are integers that can be divided by 2 with no remainder.
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="form-group mt-2">
                <label for="range">Adjust Range:</label>
                <input type="range" class="form-control-range" id="range" min="10" max="50" value="20" 
                    onchange="document.getElementById('rangeValue').innerText = this.value">
                <small class="form-text text-muted">
                    Current range: <span id="rangeValue">20</span>
                </small>
            </div>
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
    .bg-gradient-info {
        background: linear-gradient(45deg, #36b9cc, #1a8997);
    }
    .number-box {
        background-color: #f8f9fc;
        border: 1px solid #e3e6f0;
        transition: all 0.3s;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .number-box:hover {
        background-color: #4e73df;
        color: white;
        transform: scale(1.05);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>
@endsection

@section('scripts')
<script>
    document.getElementById('range').addEventListener('input', function() {
        const max = this.value;
        document.getElementById('rangeValue').innerText = max;
        
        // This would need JavaScript to dynamically update the numbers
        // In a full implementation, this would regenerate the numbers up to the selected range
    });
</script>
@endsection
@endsection
