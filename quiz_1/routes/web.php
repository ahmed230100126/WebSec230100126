<?php
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\BookController; // Add this line

Route::resource('users', UserController::class);

Route::get('register',[UserController::class,'register'])->name ('register');
Route::post('register',[UserController::class,'doRegister'])->name ('doRegister');
Route::get('login',[UserController::class,'login'])->name ('login');
Route::post('login',[UserController::class,'doLogin'])->name ('doLogin');
Route::get('logout',[UserController::class,'doLogout'])->name ('doLogout');

Route::get('/', function () {
    return view('welcome');
});

Route::get('books', [BookController::class, 'index'])->name('books.index')->middleware('auth');
Route::get('books/create', [BookController::class, 'create'])->name('books.create')->middleware('auth');
Route::post('books', [BookController::class, 'store'])->name('books.store')->middleware('auth');
Route::get('books/edit/{book}', [BookController::class, 'edit'])->name('books.edit')->middleware('auth');
Route::post('books/save/{book?}', [BookController::class, 'save'])->name('books.save')->middleware('auth');