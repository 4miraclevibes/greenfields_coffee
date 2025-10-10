<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\MenuController;
use App\Http\Controllers\Dashboard\RoomController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\TransactionController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    //Menus
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');

    //Rooms
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::get('/rooms/{room}/barcode', [RoomController::class, 'barcode'])->name('rooms.barcode');

    //Room Details (Locations)
    Route::post('/rooms/{room}/details', [RoomController::class, 'storeDetail'])->name('rooms.details.store');
    Route::put('/room-details/{roomDetail}', [RoomController::class, 'updateDetail'])->name('rooms.details.update');
    Route::delete('/room-details/{roomDetail}', [RoomController::class, 'destroyDetail'])->name('rooms.details.destroy');

    //Employees
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

    //Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');

    // Bartender Pick Transaction
    Route::get('/bartender/pick-order', [LandingController::class, 'bartenderPickOrder'])->name('bartender.pick.order');
    Route::post('/bartender/pick-order/{transaction}', [LandingController::class, 'bartenderPickOrderStore'])->name('bartender.pick.order.store');

});

// Frontend Routes (No Auth Required)
Route::get('/transaction/{roomId}', [LandingController::class, 'transaction'])->name('transaction');
Route::post('/transaction', [LandingController::class, 'storeTransaction'])->name('transaction.store');
Route::get('/transaction-result/{transactionId}', [LandingController::class, 'transactionResult'])->name('transaction.result');
Route::get('/queue', [LandingController::class, 'queue'])->name('queue');

require __DIR__.'/auth.php';
