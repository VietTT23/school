<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'AuthLogin'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'forgot_password'])->name('forgot_password');
Route::post('/forgot-password', [AuthController::class, 'post_forgot_password'])->name('post_forgot_password');
Route::get('/reset-password/{remember_token}', [AuthController::class, 'reset_password'])->name('reset_password');
Route::put('/reset-password/{remember_token}', [AuthController::class, 'update_password'])->name('update_password');



Route::group(['prefix'=>'admin', 'as'=>'admin.', 'middleware'=>'admin'], function (){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/list', [AdminController::class, 'index'])->name('index');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('create');
    Route::post('/admin/create', [AdminController::class, 'store'])->name('store');
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('edit');
    Route::put('/admin/edit/{id}', [AdminController::class, 'update'])->name('update');
    Route::put('/admin/delete/{id}', [AdminController::class, 'destroy'])->name('delete');
});

Route::group(['prefix'=>'teacher', 'as'=>'teacher.', 'middleware'=>'teacher'], function (){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});

Route::group(['prefix'=>'student', 'as'=>'student.', 'middleware'=>'student'], function (){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});
Route::group(['prefix'=>'parent', 'as'=>'parent.', 'middleware'=>'parent'], function (){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});
