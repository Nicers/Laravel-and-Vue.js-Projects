<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

//Default Route
Route::get('/', function () {
    return view('home');
});

//Authentication
Route::get('login', function () {
    return view('auth.login');
});
Route::get('register', function () {
    return view('auth.register');
});
Route::get('admin/login', function () {
    return view('admin.login');
});
Route::post('admin/loginCheck', [AdminController::class, 'login']);

// Admin Routes
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:admin', 'admin']], function () {
    Route::get('dashboard', [AdminController::class, 'index']);
    Route::post('logout', [AdminController::class, 'logout']);
});

// User Routes
Route::group(['as' => 'user.', 'prefix' => 'user', 'middleware' => ['auth', 'user']], function () {
    Route::get('dashboard', function () {
        return view('home');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
