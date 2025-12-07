<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
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

// Route::get('/', function () {
//     // return view('dashboard');
//     return [DashboardController::class, 'index'];
// });

Route::get('/', [DashboardController::class, 'index']);
Route::get('/chatbot/send', [GeminiController::class, 'scanMessage']);
Route::post('/chatbot/send', [GeminiController::class, 'sendMessage']);