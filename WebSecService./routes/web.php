<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\GradeController;
// Comment out this line since the controller doesn't exist
// use App\Http\Controllers\Web\ExamController;
use App\Http\Controllers\Web\QuizController;
use App\Http\Controllers\Web\SubmissionController;
use App\Http\Controllers\Web\OrdersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Web\ProductCommentsController;
use App\Http\Controllers\Web\ProductLikesController;

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

//Email verification routes
Route::get('verify', [UsersController::class, 'verify'])->name('verify');
Route::post('resend-verification', [UsersController::class, 'resendVerification'])->name('resend.verification');

// Password Reset Routes
Route::get('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'showLinkRequestForm'])
    ->name('password.request');
    
Route::post('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'sendResetLinkEmail'])
    ->name('password.email');
    
Route::get('/reset-password/{token}', [App\Http\Controllers\PasswordResetController::class, 'showResetForm'])
    ->name('password.reset');
    
Route::post('/reset-password', [App\Http\Controllers\PasswordResetController::class, 'reset'])
    ->name('password.update');

// Product routes
Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/{product}', [ProductsController::class, 'show'])->name('products.show');

Route::middleware(['auth', 'role:Admin|Employee'])->group(function () {
    Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
    Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
    Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');
    Route::get('products/{product}/reset', [ProductsController::class, 'resetStock'])->name('products_reset');
});

// Product comments
Route::post('products/{product}/comments', [ProductCommentsController::class, 'store'])->name('product.comments.store');
Route::delete('/product/comments/{comment}', [ProductCommentsController::class, 'destroy'])->name('product.comments.destroy');

// Product likes
Route::post('products/{product}/like', [ProductLikesController::class, 'toggleLike'])->name('products.like');

// Product favorites
Route::post('products/{product}/favorite', [ProductsController::class, 'toggleFavorite'])->name('products.toggle_favorite');

Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');
Route::get('orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
Route::get('orders/{order}/delete', [OrdersController::class, 'delete'])->name('order_delete');

Route::middleware(['auth', 'role:Customer'])->group(function () {
    // Remove cart routes and keep only the direct purchase route
    Route::post('place-order', [OrdersController::class, 'placeOrder'])->name('orders.place');
});

Route::middleware(['auth', 'role:Admin|Employee'])->group(function () {
 
    Route::get('customers/{user}/block', [UserController::class, 'toggleBlockStatus'])->name('block_user');
    
    Route::get('customers/{user}/add-credits', [OrdersController::class, 'addCreditsForm'])->name('add_credits_form');
    Route::post('customers/{user}/add-credits', [OrdersController::class, 'addCredits'])->name('add_credits');
    Route::get('orders/{order}/cancel', [OrdersController::class, 'cancelOrder'])->name('orders.cancel');
});

Route::resource('grades', GradeController::class);

// Comment out these exam routes until the controller is implemented
/*
Route::resource('exam', ExamController::class);
Route::get('exam/start', [ExamController::class, 'start'])->name('exam.start');
Route::post('exam/submit', [ExamController::class, 'submit'])->name('exam.submit');
*/

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

// Facebook authentication routes
Route::get('auth/facebook', [UsersController::class, 'redirectToFacebook'])->name('redirectToFacebook');
Route::get('auth/facebook/callback', [UsersController::class, 'handleFacebookCallback'])->name('handleFacebookCallback');

Route::get('/auth/google',
[UsersController::class, 'redirectToGoogle'])->name('login_with_google');

Route::get('/auth/google/callback',[UsersController::class, 'handleGoogleCallback']);

// GitHub OAuth Routes
Route::get('login/github', [App\Http\Controllers\UserController::class, 'redirectToGithub'])
    ->name('login.github');
Route::get('login/github/callback', [App\Http\Controllers\UserController::class, 'handleGithubCallback']);

Route::get('/cryptography', function (Request $request) {
$data = $request->data??"Welcome to Cryptography";
$action = $request->action??"Encrypt";
$result = $request->result??"";
$status = "Failed";

try {
    if($request->action=="Encrypt") {
        $temp = openssl_encrypt($request->data, 'aes-128-ecb', 'thisisasecretkey', OPENSSL_RAW_DATA, '');
        if($temp) {
            $status = 'Encrypted Successfully';
            $result = base64_encode($temp);
        }
    }
    else if($request->action=="Decrypt") {
        $temp = base64_decode($request->data);
        $result = openssl_decrypt($temp, 'aes-128-ecb', 'thisisasecretkey', OPENSSL_RAW_DATA, '');
        if($result) $status = 'Decrypted Successfully';
    }
    else if($request->action=="Hash") {
        $temp = hash('sha256', $request->data);
        $result = base64_encode($temp);
        $status = 'Hashed Successfully';
    }
    else if($request->action=="Sign") {
        $path = storage_path('app/certificates/useremail@domain.com.pfx');
        $password = '12345678';
        $certificates = [];
        if (file_exists($path)) {
            $pfx = file_get_contents($path);
            if(openssl_pkcs12_read($pfx, $certificates, $password)) {
                $privateKey = $certificates['pkey'];
                $signature = '';
                if(openssl_sign($request->data, $signature, $privateKey, 'sha256')) {
                    $result = base64_encode($signature);
                    $status = 'Signed Successfully';
                }
            } else {
                $status = 'Failed to read PFX file';
            }
        } else {
            $status = 'PFX file not found';
        }
    }
    else if($request->action=="Verify") {
        $signature = base64_decode($request->result);
        $path = storage_path('app/certificates/useremail@domain.com.crt');
        if (file_exists($path)) {
            $publicKey = file_get_contents($path);
            if(openssl_verify($request->data, $signature, $publicKey, 'sha256')) {
                $status = 'Verified Successfully';
            }
        } else {
            $status = 'Certificate file not found';
        }
    }
    else if($request->action=="KeySend") {
        $path = storage_path('app/certificates/useremail@domain.com.crt');
        if (file_exists($path)) {
            $publicKey = file_get_contents($path);
            $temp = '';
            if(openssl_public_encrypt($request->data, $temp, $publicKey)) {
                $result = base64_encode($temp);
                $status = 'Key is Encrypted Successfully';
            }
        } else {
            $status = 'Certificate file not found';
        }
    }
    else if($request->action=="KeyRecive") {
        $path = storage_path('app/certificates/useremail@domain.com.pfx');
        $password = '12345678';
        $certificates = [];
        if (file_exists($path)) {
            $pfx = file_get_contents($path);
            if(openssl_pkcs12_read($pfx, $certificates, $password)) {
                $privateKey = $certificates['pkey'];
                $encryptedKey = base64_decode($request->data);
                $result = '';
                if(openssl_private_decrypt($encryptedKey, $result, $privateKey)) {
                    $status = 'Key is Decrypted Successfully';
                }
            } else {
                $status = 'Failed to read PFX file';
            }
        } else {
            $status = 'PFX file not found';
        }
    }
} catch (\Exception $e) {
    $status = 'Error: ' . $e->getMessage();
}

return view('cryptography', compact('data', 'result', 'action', 'status'));
})->name('cryptography');