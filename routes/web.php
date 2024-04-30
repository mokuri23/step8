<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
// use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 一覧画面
Route::get('/index', [ProductController::class, 'index'])->name('index');
// 新規登録画面
Route::get('/create', [ProductController::class, 'create'])->name('create');
// 登録
Route::post('/store', [ProductController::class, 'store'])->name('store');
// 編集画面
Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
// 詳細画面
Route::get('/show/{id}', [ProductController::class, 'show'])->name('show');
// 更新
Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');
// 削除
Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('delete');
// 検索
Route::get('/search', [ProductController::class, 'search'])->name('search');
// 購入
Route::get('/cart/{id}', [ProductController::class, 'cart'])->name('cart');
Route::post('/purchase/{id}', [ProductController::class, 'purchase'])->name('purchase');



require __DIR__ . '/auth.php';
