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

Route::get('/profile', [MainController::class, 'profile_show'])->middleware('auth');


//Route::get('/about', 'MainController@about');
//Route::get('/about', [MainController::class, "about"] );
Route::get('/request', [MainController::class, "request"] );
Route::post('/request/send', [MainController::class, "request_send"] );
// Route::get('/request_show', [MainController::class, "request_show"] );

Route::post('/requests/{id}/accept', [MainController::class, 'accept'])->name('requests.accept');
Route::post('/requests/{id}/complete', [MainController::class, 'complete'])->name('requests.complete');
Route::post('/requests/{id}/decline', [MainController::class, 'decline'])->name('requests.decline');
Route::post('/requests/{id}/not-completed', [MainController::class, 'markAsNotCompleted'])->name('requests.markAsNotCompleted');

Route::delete('/requests/{id}', [MainController::class, 'destroy'])->name('requests.destroy');


Route::get('/users_show', [MainController::class, 'users_show'])->name('users.users_show');
Route::post('/users/{id}/role_id', [MainController::class, 'updateRole'])->name('users.updateRole');

Route::get('/request_show', [MainController::class, 'request_show'])->name('requests.request_show');

Route::get('/review', [MainController::class, "review"] )->name('review');
Route::post('/review/check', [MainController::class, "review_check"] );

Route::get('/chat', [MainController::class, 'chat'])->name('chat');
Route::post('/chat_accept', [MainController::class, "chat_accept"] );

// Route::get('/user/{id}/{name}', function ($id, $name) {
//     return 'ID: '. $id.'. Name: '.$name;
// });
