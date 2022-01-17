<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KomdaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect(route('login'));
});

Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth','HasPermission'])->group(function () {
    // User
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/create', [UserController::class, 'store'])->name('user.create');
    Route::delete('/user/destroy/{user}',[UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/user/edit/{user:email}',[UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/edit/{user}',[UserController::class, 'update'])->name('user.edit');
    
    // Komda
    Route::get('/komda', [KomdaController::class, 'index'])->name('komda');
    Route::get('/komda/create', [KomdaController::class, 'create'])->name('komda.create');
    Route::post('/komda/create', [KomdaController::class, 'store'])->name('komda.create');
    Route::delete('/komda/destroy/{komda}',[KomdaController::class, 'destroy'])->name('komda.destroy');
    Route::get('/komda/edit/{komda}',[KomdaController::class, 'edit'])->name('komda.edit');
    Route::put('/komda/edit/{komda}',[KomdaController::class, 'update'])->name('komda.edit');
});
