<?php
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('welcome'); //welcome.blade.php
    });
Route::get('multable/{id}', function ($id) {
    return view('multable' , [
        'number'=>$id ,
    ]);
});
Route::get('/prime ', function () {
    return view('prime',);
});

Route::get('test/{id}', function ($id) {
    $courses = [
        '1' => 'englach',
        '2' => 'oop',
        '3' => 'ara'
    ];
    return view('test' , [
        'this_id' => $courses[$id] ?? "does not exsist",
    ]);
});

Route::resource('users', UserController::class);
Route::resource('grades', GradeController::class);

Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');
Route::get('register',[UserController::class,'register'])->name ('register');
Route::post('register',[UserController::class,'doRegister'])->name ('doRegister');
Route::get('login',[UserController::class,'login'])->name ('login');
Route::post('login',[UserController::class,'doLogin'])->name ('doLogin');
Route::post('logout',[UserController::class,'doLogout'])->name ('doLogout');
Route::get('profile/{user?}', [UserController::class, 'profile'])->name('profile')->middleware('auth');
Route::post('profile/update-password/{user?}', [UserController::class, 'updatePassword'])->name('updatePassword')->middleware('auth');
Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('auth');
Route::get('users/edit/{user?}', [UserController::class, 'edit'])->name('users_edit')->middleware('auth');
Route::post('users/save/{user}', [UserController::class, 'save'])->name('users_save')->middleware('auth');

Route::get('books', [BookController::class, 'index'])->name('books.index')->middleware('auth');
Route::get('books/create', [BookController::class, 'create'])->name('books.create')->middleware('auth');
Route::post('books', [BookController::class, 'store'])->name('books.store')->middleware('auth');
Route::get('books/edit/{book}', [BookController::class, 'edit'])->name('books.edit')->middleware('auth');
Route::post('books/save/{book?}', [BookController::class, 'save'])->name('books.save')->middleware('auth');

Route::resource('roles', RoleController::class)->middleware('auth');