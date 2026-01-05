<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\MailController;


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
    Route::get('/t', [DashboardController::class, 'diagnose'])->name('diagnose');

    // save log alert
    Route::post('/savelog', [DashboardController::class, 'saveLog'])->name('dashboard.saveLog');

    // send message to chatbot
    Route::get('/chatbot/send', [GeminiController::class, 'getMessage'])->name('chatbot.get');
    Route::post('/chatbot/send', [GeminiController::class, 'sendMessage'])->name('chatbot.send');

    
    // user route
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    
    // Mail 
    Route::get('/mail', [MailController::class, 'index'])->name('mail.index');
    Route::get('/mail/setting', [MailController::class, 'settingMail'])->name('mail.settingMail');
    Route::get('/mail/{id}', [MailController::class, 'show'])->name('mail.show');
    Route::post('/mail/store', [MailController::class, 'store'])->name('mail.store');


    
    
    
    // Check admin or owner
    Route::middleware(['owner_or_admin'])->group(function () {

        // create user
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user/create', [UserController::class, 'store'])->name('user.store');
        // delete user
        Route::get('/user/edit/delete/{user_id}', [UserController::class, 'destroy'])->name('user.destroy');
        // edit user
        Route::get('/user/edit/{user_id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/edit/{user_id}', [UserController::class, 'update'])->name('user.update');
        
        // change pass
        Route::get('/user/{user_id}', [UserController::class, 'show'])->name('user.show');
        Route::put('/user/{user_id}', [UserController::class, 'changePass'])->name('user.changePass');

        // permission route
        Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
        // permission create
        Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create');
        Route::post('/permission/create', [PermissionController::class, 'store'])->name('permission.store');
        // permission edit
        Route::get('/permission/edit/{permission_id}', [PermissionController::class, 'edit'])->name('permission.edit');
        // permission update
        Route::put('/permission/edit/{permission_id}', [PermissionController::class, 'update'])->name('permission.update');
        // permission delete
        Route::get('/permission/edit/delete/{permission_id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
    });

    // check admin
    Route::middleware(['checkadmin'])->group(function () {
        
    });
});

Route::get('/sendmail', [MailController::class, 'sendmail'])->name('mail.sendmail');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/fakeuser', [AuthController::class, 'fakeUser'])->name('fakeuser');
Route::get('/fakepermission', [PermissionController::class, 'fakepermission'])->name('fakepermission');
