<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(UserController::class)->group(function () {
    Route::post('createRanking', 'createRanking');
    Route::get('getRanking/{id}', 'getRanking');
    Route::get('updateRanking/{userId}', 'updateRanking');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('addPost', [HomeController::class, 'addPost'])->name('addPost');
