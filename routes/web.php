<?php


use App\Http\Controllers\MainController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\KnowledgeBaseController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

// маршрут на главную страницу
Route::get('/', [MainController::class, 'home']);

// маршруты для регистрации, входа и выхода из аккаунта
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');
});

// маршрут на профиль
Route::get('/profile', [MainController::class, 'profile_show'])->middleware('auth');


// отправка заявки
Route::get('/request', [MainController::class, "request"] );
Route::post('/request/send', [MainController::class, "request_send"] );

// действия исполнителя
Route::post('/requests/{id}/accept', [MainController::class, 'accept'])->name('requests.accept');
Route::post('/requests/{id}/complete', [MainController::class, 'complete'])->name('requests.complete');
Route::post('/requests/{id}/decline', [MainController::class, 'decline'])->name('requests.decline');
Route::post('/requests/{id}/not-completed', [MainController::class, 'markAsNotCompleted'])->name('requests.markAsNotCompleted');

// удаления заявки
Route::delete('/requests/{id}', [MainController::class, 'destroy'])->name('requests.destroy');

// действия менеджера
Route::post('/requests/{id}/check', [ManagerController::class, 'check'])->name('requests.check');
Route::post('/requests/{id}/mark-checked', [ManagerController::class, 'markAsChecked'])->name('requests.markChecked');
Route::post('/requests/{id}/update-executor', [ManagerController::class, 'updateExecutor'])->name('requests.updateExecutor');


// действия администратора
Route::get('/users_show', [AdminController::class, 'users_show'])->name('users.users_show');
Route::post('/users/{id}/role_id', [AdminController::class, 'updateRole'])->name('users.updateRole');

// показ заявок
Route::get('/request_show', [MainController::class, 'request_show'])->name('requests.request_show');

// чат-бот
Route::get('/chat', [ChatController::class, 'chat'])->name('chat');
Route::post('/chat_accept', [ChatController::class, "chat_accept"] );

// база знаний
Route::get('/knowledge_base', [KnowledgeBaseController::class, 'index']);
Route::get('/knowledge_base/upload', [KnowledgeBaseController::class, 'create'])->name('knowledge_base.upload.form');
Route::post('/knowledge_base/upload', [KnowledgeBaseController::class, 'store'])->name('knowledge_base.upload');
Route::get('/knowledge_base/{filename}', [KnowledgeBaseController::class, 'show']);
Route::delete('/knowledge_base/{filename}', [KnowledgeBaseController::class, 'destroy'])->name('files.destroy');

