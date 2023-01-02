<?php

use Illuminate\Support\Facades\Route;
use VipSoft\TmdbQuery\Http\Controllers\PageController;

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

Route::namespace('core')->group(function() {
    Route::get('/tmdb', [PageController::class, 'index'])->name('page.index');
    Route::get('/tmdb/{id}', [PageController::class, 'view'])->name('page.view');
});
