<?php
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GradeController;

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
Route::get('products', [TestController::class,'list'])->name('products_list');
Route::resource('grades', GradeController::class);