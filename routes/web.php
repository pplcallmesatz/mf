<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntriesListController;

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
    return view('auth.login');
});

Auth::routes();

//Route::get('/arun-sir',[\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/entries', [EntriesListController::class, 'index'])->name('entries.index');
Route::post('/entries/store', [EntriesListController::class, 'store'])->name('entries.store');
Route::post('/entries', [EntriesListController::class, 'store'])->name('entries.store');
Route::put('/entries/{id}', [EntriesListController::class, 'update']);
Route::delete('/entries/{id}', [EntriesListController::class, 'destroy']);



