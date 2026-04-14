<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TicketController;

use App\Http\Controllers\TicketTypeController;
use App\Http\Controllers\User\EventController as UserEventController;
use App\Http\Controllers\User\PaymentController;

use App\Http\Controllers\Organizer\DashboardController;
use App\Http\Controllers\Organizer\ServiceController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->role_id == 1) {
            return redirect('/admin/dashboard');
        } elseif ($user->role_id == 2) {
            return redirect('/organizer/dashboard');
        } else {
            return redirect('/user/dashboard');
        }
    }

    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');

Route::get('/register', [RegisterController::class, 'showRegister'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'register'])->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| ADMIN (role:1)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:1'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/admin/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/admin/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/admin/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/admin/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/admin/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::resource('admin/categories', CategoryController::class, [
        'names' => [
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ]
    ]);

    Route::prefix('admin/events/{event_id}/ticket')->group(function () {
        Route::get('/', [TicketTypeController::class, 'index'])->name('ticket.index');
        Route::get('/create', [TicketTypeController::class, 'create'])->name('ticket.create');
        Route::post('/store', [TicketTypeController::class, 'store'])->name('ticket.store');
    });

    Route::get('/admin/ticket/{id}/edit', [TicketTypeController::class, 'edit'])->name('ticket.edit');
    Route::post('/admin/ticket/{id}/update', [TicketTypeController::class, 'update'])->name('ticket.update');
    Route::get('/admin/ticket/{id}/delete', [TicketTypeController::class, 'destroy'])->name('ticket.delete');
});

/*
|--------------------------------------------------------------------------
| ORGANIZER (role:2)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:2'])->group(function () {

    Route::get('/organizer/dashboard', [DashboardController::class, 'index'])->name('organizer.dashboard');

    Route::get('/organizer/waiting-list', [ServiceController::class, 'waitingList'])
        ->name('organizer.waiting-list');

    Route::get('/organizer/orders', [ServiceController::class, 'orders'])
        ->name('organizer.orders');

    Route::post('/organizer/orders/{id}/approve', [ServiceController::class, 'approve'])
        ->name('organizer.orders.approve');

    Route::post('/organizer/orders/{id}/reject', [ServiceController::class, 'reject'])
        ->name('organizer.orders.reject');

    Route::post('/organizer/process-waiting/{id}', [ServiceController::class, 'processWaitingList']);

    Route::get('/organizer/order-history', [ServiceController::class, 'orderHistory'])->name('organizer.orders.history');
});

/*
|--------------------------------------------------------------------------
| USER (role:3)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:3'])->group(function () {

    Route::get('/user/dashboard', [UserEventController::class, 'dashboard'])->name('user.dashboard');

    Route::prefix('user/events')->group(function () {
        Route::get('/', [UserEventController::class, 'index'])->name('user.events.index');
        Route::get('/history', [UserEventController::class, 'history'])->name('user.events.history');
        Route::get('/{id}', [UserEventController::class, 'show'])->name('user.events.show');
        Route::get('/{id}/register', [UserEventController::class, 'register'])->name('user.events.register');
        Route::post('/{id}/register', [UserEventController::class, 'storeRegistration'])->name('user.events.store');
        Route::delete('/{id}/cancel', [UserEventController::class, 'cancelOrder'])->name('user.events.cancel');
    });

    Route::prefix('user/payment')->group(function () {
        Route::get('/order/{id}', [PaymentController::class, 'show'])->name('user.payment.show');
        Route::post('/order/{id}', [PaymentController::class, 'process'])->name('user.payment.process');
        Route::get('/verify/{id}', [PaymentController::class, 'verify'])->name('user.payment.verify');
        Route::get('/success/{id}', [PaymentController::class, 'success'])->name('user.payment.success');
        Route::get('/history', [PaymentController::class, 'history'])->name('user.payment.history');
        Route::get('/download-ticket/{id}', [PaymentController::class, 'downloadTicket'])->name('user.payment.download-ticket');
    });
});

/*
|--------------------------------------------------------------------------
| SCAN / VALIDATE (ADMIN/ORGANIZER TOOL)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/organizer/scan', [TicketController::class, 'scan'])->name('organizer.scan');
    Route::post('/validate-qr', [TicketController::class, 'validateQr']);
    Route::get('/checkin/{kode}', [TicketController::class, 'manual']);
});

/*
|--------------------------------------------------------------------------
| ORGANIZER EXPORT
|--------------------------------------------------------------------------
*/
Route::get('/organizer/export-excel', [DashboardController::class, 'exportExcel'])
    ->name('organizer.export.excel');