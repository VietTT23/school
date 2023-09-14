<?php

use App\Http\Controllers\AuthController;
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
//Route::get('/', [\App\Http\Controllers\AuthController::class, 'login'])->name('forgot_password');
//Route::get('/', [\App\Http\Controllers\AuthController::class, 'login'])->name('register');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/admin/list', function () {
    return view('admin.admin.list');
})->name('admin.list');

Route::group(['middleware'=>'admin'], function (){});
Route::group(['middleware'=>'teacher'], function (){});
Route::group(['middleware'=>'student'], function (){});
Route::group(['middleware'=>'parent'], function (){});
