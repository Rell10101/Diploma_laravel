<?php

//use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;

//Route::get('/', 'MainController@home');
Route::get('/', [MainController::class, 'home']);

//Route::get('/about', 'MainController@about');
//Route::get('/about', [MainController::class, "about"] );
Route::get('/request', [MainController::class, "request"] );
Route::post('/request/send', [MainController::class, "request_send"] );
Route::get('/request_show', [MainController::class, "request_show"] );

Route::get('/review', [MainController::class, "review"] )->name('review');
Route::post('/review/check', [MainController::class, "review_check"] );

// Route::get('/user/{id}/{name}', function ($id, $name) {
//     return 'ID: '. $id.'. Name: '.$name;
// });
