<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\GradeController;
use App\Http\Controllers\Web\ExamController;
use App\Http\Controllers\Web\QuizController;
use App\Http\Controllers\Web\SubmissionController;
use App\Http\Controllers\Web\OrdersController;
use App\Http\Controllers\UserController;

Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('users', [UsersController::class, 'list'])->name('users');
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');

Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::middleware(['auth', 'role:Admin|Employee'])->group(function () {
    Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
    Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
    Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');
    Route::get('products/{product}/reset', [ProductsController::class, 'resetStock'])->name('products_reset');
});

Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');
Route::get('orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
Route::get('orders/{order}/delete', [OrdersController::class, 'delete'])->name('order_delete');

Route::middleware(['auth', 'role:Customer'])->group(function () {
    // Remove cart routes and keep only the direct purchase route
    Route::post('place-order', [OrdersController::class, 'placeOrder'])->name('orders.place');
});

Route::middleware(['auth', 'role:Admin|Employee'])->group(function () {
    Route::get('customers/{user}/add-credits', [OrdersController::class, 'addCreditsForm'])->name('add_credits_form');
    Route::post('customers/{user}/add-credits', [OrdersController::class, 'addCredits'])->name('add_credits');
    Route::get('orders/{order}/cancel', [OrdersController::class, 'cancelOrder'])->name('orders.cancel');
});

Route::resource('grades', GradeController::class);

Route::resource('exam', ExamController::class);
Route::get('exam/start', [ExamController::class, 'start'])->name('exam.start');
Route::post('exam/submit', [ExamController::class, 'submit'])->name('exam.submit');

Route::middleware(['auth'])->group(function () {
    // Quiz routes
    Route::resource('quizzes', QuizController::class);

    // Submission routes
    Route::post('quizzes/{quiz}/submit', [SubmissionController::class, 'submit'])->name('submissions.submit');
    Route::put('submissions/{submission}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');
    Route::get('student/results', [SubmissionController::class, 'studentResults'])->name('student.results');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/multable', function (Request $request) {
    $j = $request->number??5;
    $msg = $request->msg;
    return view('multable', compact("j", "msg"));
});

Route::get('/even', function () {
    return view('even');
});

Route::get('/prime', function () {
    return view('prime');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/transcript', function () {
    $transcript = [
        'Mathematics' => 'A',
        'Physics' => 'B+',
        'Chemistry' => 'A-',
        'Biology' => 'B',
        'Computer Science' => 'A+'
    ];
    return view('transcript', ['transcript' => $transcript]);
});

Route::get('/calculator', function () {
    return view('calculator');
});

// Customer management routes
Route::middleware(['auth', 'role:Admin|Employee'])->group(function () {
    // Add this new section for customer management
    Route::get('customers', [UserController::class, 'customers'])->name('users.customers');
    Route::get('customers/{user}/credits', [UserController::class, 'showAddCredits'])->name('users.credits.show');
    Route::post('customers/{user}/credits', [UserController::class, 'addCredits'])->name('users.credits.add');
    Route::get('customers/{user}/reset-credits', [UserController::class, 'resetCredits'])->name('users.credits.reset');
    Route::get('customers/delete/{user}', [UserController::class, 'delete'])->name('customers_delete');
});

// User profile route (moved from old UsersController to new one)
Route::get('user/profile/{user?}', [UserController::class, 'profile'])->name('user.profile');

// Admin routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('employees/create', [UserController::class, 'createEmployee'])->name('create_employee');
    Route::post('employees/store', [UserController::class, 'storeEmployee'])->name('store_employee');
});
