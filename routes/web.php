<?php

use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\MenuController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\SliderController;
use App\Http\Controllers\backend\SettingController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\PermissionController;
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

Route::group(['prefix' => 'category', 'as' => 'category.'], function (){
    Route::get('', [CategoryController::class, 'index','middleware' => 'can:category-list'])->name('index');
    Route::get('/create', [CategoryController::class, 'create','middleware' => 'can:category-create'])->name('create');
    Route::post('', [CategoryController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CategoryController::class, 'edit','middleware' => 'can:category-edit'])->name('edit');
    Route::put('{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoryController::class, 'delete','middleware' => 'can:category-delete'])->name('delete');
});

Route::group(['prefix' => 'menu', 'as' => 'menu.', 'middleware' => 'can:menu-list'], function (){
    Route::get('', [MenuController::class, 'index'])->name('index');
    Route::get('/create', [MenuController::class, 'create'])->name('create');
    Route::post('', [MenuController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit');
    Route::put('{id}', [MenuController::class, 'update'])->name('update');
    Route::delete('/{id}', [MenuController::class, 'delete'])->name('delete');
});
Route::group(['prefix' => 'product', 'as' => 'product.'], function (){
    Route::get('', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('', [ProductController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProductController::class, 'delete'])->name('delete');
});
Route::group(['prefix' => 'slider', 'as' => 'slider.'], function (){
    Route::get('', [SliderController::class, 'index'])->name('index');
    Route::get('/create', [SliderController::class, 'create'])->name('create');
    Route::post('', [SliderController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [SliderController::class, 'edit'])->name('edit');
    Route::put('{id}', [SliderController::class, 'update'])->name('update');
    Route::delete('/{id}', [SliderController::class, 'delete'])->name('delete');
});
Route::group(['prefix' => 'settings', 'as' => 'settings.'], function (){
    Route::get('', [SettingController::class, 'index'])->name('index');
    Route::get('/create', [SettingController::class, 'create'])->name('create');
    Route::post('', [SettingController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [SettingController::class, 'edit'])->name('edit');
    Route::put('{id}', [SettingController::class, 'update'])->name('update');
    Route::delete('/{id}', [SettingController::class, 'delete'])->name('delete');
});
Route::group(['prefix' => 'users', 'as' => 'users.'], function (){
    Route::get('', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('', [UserController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'delete'])->name('delete');
});
Route::group(['prefix' => 'roles', 'as' => 'roles.'], function (){
    Route::get('', [RoleController::class, 'index'])->name('index');
    Route::get('/create', [RoleController::class, 'create'])->name('create');
    Route::post('', [RoleController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit');
    Route::put('{id}', [RoleController::class, 'update'])->name('update');
    Route::delete('/{id}', [RoleController::class, 'delete'])->name('delete');
});
Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function (){
    Route::get('', [PermissionController::class, 'createPermissions'])->name('index');
    Route::post('', [PermissionController::class, 'store'])->name('store');
});
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/category/{slug}/{id}', [\App\Http\Controllers\CategoryController::class,'index'])->name('category.product');

