<?php

//use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

//Route::get('/', 'MainController@home');
Route::get('/', [MainController::class, 'home']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Создайте представление dashboard.blade.php
    })->name('dashboard');
});


//Route::get('/about', 'MainController@about');
//Route::get('/about', [MainController::class, "about"] );
Route::get('/request', [MainController::class, "request"] );
Route::post('/request/send', [MainController::class, "request_send"] );
// Route::get('/request_show', [MainController::class, "request_show"] );

Route::get('/request_show', [MainController::class, 'request_show'])->name('requests.request_show');

Route::get('/review', [MainController::class, "review"] )->name('review');
Route::post('/review/check', [MainController::class, "review_check"] );

// Route::get('/user/{id}/{name}', function ($id, $name) {
//     return 'ID: '. $id.'. Name: '.$name;
// });
