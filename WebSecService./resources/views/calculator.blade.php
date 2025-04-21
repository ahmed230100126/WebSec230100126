@extends('layouts.master')
@section('title', 'Calculator')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0"><i class="fas fa-calculator me-2"></i>Scientific Calculator</h4>
                </div>
                <div class="card-body p-4">
                    <form id="calculator-form" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="number1" placeholder="Enter first number" required>
                                    <label for="number1">First Number</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="number2" placeholder="Enter second number" required>
                                    <label for="number2">Second Number</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-floating mb-4">
                            <select class="form-select" id="operation" required>
                                <option value="add">Addition (+)</option>
                                <option value="subtract">Subtraction (-)</option>
                                <option value="multiply">Multiplication (×)</option>
                                <option value="divide">Division (÷)</option>
                            </select>
                            <label for="operation">Select Operation</label>
                        </div>
                        
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary btn-lg" onclick="calculate()">
                                Calculate <i class="fas fa-equals ms-2"></i>
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-4 text-center">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="text-muted mb-2">Result</h5>
                                <h3 class="mb-0" id="result">-</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function calculate() {
    const number1 = parseFloat(document.getElementById('number1').value);
    const number2 = parseFloat(document.getElementById('number2').value);
    const operation = document.getElementById('operation').value;
    let result;

    if (isNaN(number1) || isNaN(number2)) {
        document.getElementById('result').innerText = 'Please enter valid numbers';
        return;
    }

    switch (operation) {
        case 'add':
            result = number1 + number2;
            break;
        case 'subtract':
            result = number1 - number2;
            break;
        case 'multiply':
            result = number1 * number2;
            break;
        case 'divide':
            if (number2 === 0) {
                result = 'Cannot divide by zero';
            } else {
                result = number1 / number2;
            }
            break;
        default:
            result = 'Invalid operation';
    }

    document.getElementById('result').innerText = typeof result === 'number' ? result.toLocaleString() : result;
}
</script>
@endsection
