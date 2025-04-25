@extends('layouts.master')
@section('title', 'Prime Numbers')
@section('content')
  @php
    if (!function_exists('isPrime')) {
        function isPrime($number) {
            if($number <= 1) return false;
            $i = $number - 1;
            while($i > 1) {
                if($number % $i == 0) return false;
                $i--;
            }
            return true;
        }
    }
  @endphp
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0"><i class="fas fa-square-root-alt me-2"></i>Prime Numbers (1-100)</h4>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach (range(1, 100) as $i)
                            <div class="col-auto">
                                @if(isPrime($i))
                                    <div class="number-badge prime">
                                        {{$i}}
                                    </div>
                                @else
                                    <div class="number-badge non-prime">
                                        {{$i}}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center">
                                <div class="number-badge prime me-2">P</div>
                                <span>Prime Numbers</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="number-badge non-prime me-2">N</div>
                                <span>Non-Prime Numbers</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.number-badge {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    font-weight: 500;
    transition: transform 0.2s;
}

.number-badge:hover {
    transform: scale(1.1);
}

.prime {
    background-color: #4CAF50;
    color: white;
    box-shadow: 0 2px 4px rgba(76, 175, 80, 0.2);
}

.non-prime {
    background-color: #f8f9fa;
    color: #6c757d;
    border: 1px solid #dee2e6;
}
</style>
@endsection
