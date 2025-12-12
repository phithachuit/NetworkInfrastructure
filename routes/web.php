<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\GeminiController;

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

Route::middleware(['authm'])->group(function () {
    // dashboard route
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // send message to chatbot
    Route::get('/chatbot/send', [GeminiController::class, 'getMessage'])->name('chatbot.get');
    Route::post('/chatbot/send', [GeminiController::class, 'sendMessage'])->name('chatbot.send');

    // user route
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/create', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{user_id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/edit/{user_id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/edit/{user_id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/edit/delete/{user_id}', [UserController::class, 'destroy'])->name('user.destroy');

    // permission route
    Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/permission/create', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permission/edit/{permission_id}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::put('/permission/edit/{permission_id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::get('/permission/edit/delete/{permission_id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/fakeuser', [AuthController::class, 'fakeUser'])->name('fakeuser');
Route::get('/fakepermission', [PermissionController::class, 'fakepermission'])->name('fakepermission');
