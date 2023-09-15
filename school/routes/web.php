<?php

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
//Route::get('/', [\App\Http\Controllers\AuthController::class, 'login'])->name('register');


Route::get('/admin/admin/list', function () {
    $user = \Illuminate\Support\Facades\Auth::user();
    $user_type = \Illuminate\Support\Facades\Auth::user()->user_type;
    return view('admin.admin.list', [
        'user'=>$user,
        'user_type'=>$user_type,
    ]);
})->name('admin.list');

Route::group(['prefix'=>'admin', 'as'=>'admin.', 'middleware'=>'admin'], function (){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
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
