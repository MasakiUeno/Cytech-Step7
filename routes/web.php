<?php

use App\Http\Controllers\ArticleController;
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

Route::get('/articles', [ArticleController::class, 'index'])->name('index'); //商品一覧
Route::get('/articles/creat', [ArticleController::class, 'creat'])->name('creat'); //商品新規
Route::get('/articles/show/{id}', [ArticleController::class, 'show'])->name('show'); //商品詳細
Route::get('/articles/edit/{id}', [ArticleController::class, 'edit'])->name('edit'); //商品編集

Route::post('/articles/update/{id}', [ArticleController::class,'update'])->name('update');//更新

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');