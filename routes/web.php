<?php

use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\MenuController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'category', 'as' => 'category.'], function (){
    Route::get('', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('', [CategoryController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::put('{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoryController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => 'menu', 'as' => 'menu.'], function (){
    Route::get('', [MenuController::class, 'index'])->name('index');
    Route::get('/create', [MenuController::class, 'create'])->name('create');
    Route::post('', [MenuController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit');
    Route::put('{id}', [MenuController::class, 'update'])->name('update');
    Route::delete('/{id}', [MenuController::class, 'delete'])->name('delete');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
