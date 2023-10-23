<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'displayContent']

);

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/cards', [CardController::class, 'index'])->name('cards.index');
    Route::get('/cards/create', [CardController::class, 'create'])->name('cards.create');
    Route::post('/cards', [CardController::class, 'store'])->name('cards.store');
    Route::post('/cards/{card}/toggle', [CardController::class, 'toggle'])->name('cards.toggle');
    Route::delete('/cards/{card}', [CardController::class, 'delete'])->name('cards.delete');
    Route::delete('/cards', [CardController::class, 'deleteAll'])->name('cards.deleteAll');

});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::delete('/admin/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
    Route::get('/admin/make-admin/{id}', [AdminController::class, 'makeAdmin'])->name('admin.makeAdmin');
    Route::delete('/admin/remove-admin/{id}', [AdminController::class, 'removeAdmin'])->name('admin.removeAdmin');
});
