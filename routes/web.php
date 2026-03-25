<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EventController;

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

