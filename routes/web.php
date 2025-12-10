<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserDashboard;
use App\Http\Controllers\AuthController;
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

    // user dashboard route
    Route::get('/user', [UserDashboard::class, 'index'])->name('user');
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('fakeuser', [AuthController::class, 'fakeUser'])->name('fakeuser');
