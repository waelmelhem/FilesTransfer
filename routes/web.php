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


Route::get('/dashboard/link', [FileController::class, 'dashLink'])->name('dashboard.links');
Route::get('/dashboard/MoreInfo/{id}', [FileController::class, 'dashInfo'])->name('dashboard.Info');
Route::get('/dashboard/edit/{id}', [FileController::class, 'dashEdit'])->name('dashboard.edit');
Route::get('/dashboard/editFile/{id}/{name}', [FileController::class, 'FileEdit'])->name('File.edit');
Route::get('/dashboard/deleteFile/{id}', [FileController::class, 'fileDelete'])->name('file.delete');
Route::post('/dashboard/addFile', [FileController::class, 'fileAdd'])->name('file.add');
Route::post('/dashboard/edit/link', [FileController::class, 'editlink'])->name('dashboard.edit.link');
Route::post('/dashboard/delete/link', [FileController::class, 'delete_groub'])->name('dashboard.groub.delete');

//
//

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard.dashboard');
})->name('dashboard');
