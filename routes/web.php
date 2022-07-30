<?php

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
    return view('/welcome');
});

Auth::routes();

// ホーム画面
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 投稿一覧画面
Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts');

// 投稿作成画面
Route::get('/post_register', [App\Http\Controllers\PostController::class, 'post_register'])->name('post_register');
Route::post('/postRegister', [App\Http\Controllers\PostController::class, 'postRegister'])->name('postRegister');

// 投稿編集画面
Route::get('/post_edit/{post}', [App\Http\Controllers\PostController::class, 'post_edit']);
Route::post('/post_edit', [App\Http\Controllers\PostController::class, 'edit'])->name('post_edit');

// 投稿削除
Route::get('/post_delete/{post}', [App\Http\Controllers\PostController::class, 'destroy']);

// ユーザーのアカウント編集画面
Route::get('/user_edit', [App\Http\Controllers\UserController::class, 'user_edit'])->name('user_edit');
Route::post('/userEdit', [App\Http\Controllers\UserController::class, 'userEdit'])->name('userEdit');

// ユーザーの詳細画面
Route::get('/user_detail/{id}', [App\Http\Controllers\UserController::class, 'user_detail']);

// ユーザー一覧画面
Route::get('/user_table', [App\Http\Controllers\UserController::class, 'user_table'])->name('user_table');

