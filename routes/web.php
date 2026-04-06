<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;//追加した

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

Route::get('/product', [ProductController::class, 'index'])->name('index'); //商品一覧
Route::get('/product/creat', [ProductController::class, 'creat'])->name('creat'); //商品新規
Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('show'); //商品詳細
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('edit'); //商品編集

Route::post('/product/update/{id}', [ProductController::class,'update'])->name('update');//更新
Route::post('/product/store', [ProductController::class, 'store'])->name('store');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('destroy');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');