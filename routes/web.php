<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout']);

Route::middleware(['auth', 'role:1'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // 📌 INDEX (list event)
    Route::get('/admin/events', [EventController::class, 'index'])
        ->name('events.index');

    // 📌 CREATE FORM
    Route::get('/admin/events/create', [EventController::class, 'create'])
        ->name('events.create');

    // 📌 STORE
    Route::post('/admin/events', [EventController::class, 'store'])
        ->name('events.store');
    // 📌 EDIT
    Route::get('/admin/events/{id}/edit', [EventController::class, 'edit'])
        ->name('events.edit');

    // 📌 UPDATE
    Route::put('/admin/events/{id}', [EventController::class, 'update'])
        ->name('events.update');

    Route::delete('/admin/events/{id}', [EventController::class, 'destroy'])
        ->name('events.destroy');


    // 📌 INDEX (list user)
    Route::get('/admin/users', [UserController::class, 'index'])
        ->name('admin.users.index');

    // 📌 CREATE FORM
    Route::get('/admin/users/create', [UserController::class, 'create'])
        ->name('admin.users.create');

    // 📌 STORE
    Route::post('/admin/users', [UserController::class, 'store'])
        ->name('admin.users.store');

    // 📌 EDIT
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])
        ->name('admin.users.edit');

    // 📌 UPDATE
    Route::put('/admin/users/{id}', [UserController::class, 'update'])
        ->name('admin.users.update');

    // 📌 DELETE
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])
        ->name('admin.users.destroy');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

});

Route::middleware(['auth', 'role:2'])->group(function () {

    Route::get('/organizer/dashboard', function () {
        return view('organizer.dashboard');
    })->name('organizer.dashboard');

});

Route::middleware(['auth', 'role:3'])->group(function () {

    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

