<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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
/*
Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [HomeController::class, 'index'])
    //->middleware('throttle:10,1')
    ->name('home.index');

Route::middleware('auth')
    ->prefix('dashboard/contacts')
    ->name('dashboard.contacts.')
    ->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::get('/create', [ContactController::class, 'create'])->name('create');
    Route::post('/', [ContactController::class, 'store'])->name('store');
    Route::get('/{contact}', [ContactController::class, 'show'])->name('show');
    Route::get('/{contact}/edit', [ContactController::class, 'edit'])->name('edit');
    Route::put('/{contact}', [ContactController::class, 'update'])->name('update');
    Route::delete('/{contact}', [ContactController::class, 'destroy'])->name('destroy');
});



/**
 * Default Laravel Breeze routes for authentication and dashboard access.
 */

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
