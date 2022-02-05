<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

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
    return view('welcome');
});
Route::post('/visitor/add', [FileController::class, 'add'])->name('visitor.add');
Route::get('/display/{id}', [FileController::class, 'display'])->name('display');
Route::get('/download/{id}', [FileController::class, 'download'])->name('download');
Route::post('/password/check', [FileController::class, 'password_check'])->name('password.Check');
Route::get('password/{id}', [FileController::class, 'password'])->name('password');
Route::post('/dashboard/add', [FileController::class, 'DashAdd'])->name('dashboard.add');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard.dashboard');
})->name('dashboard');
