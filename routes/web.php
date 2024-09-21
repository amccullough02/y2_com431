<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TrashedPostController;
use App\Http\Controllers\CommentController;

Route::resource('posts', PostController::class);
Route::resource('comments', CommentController::class);

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
    DebugBar::info('Hello world!');
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/posts', PostController::class);
});

Route::prefix('/comments')->name('comments.')->middleware('auth')->group(function () {
    Route::get('/create/{post}', [CommentController::class, 'create'])->name('create');
    Route::post('/store{post}', [CommentController::class, 'store'])->name('store');
});

Route::prefix('/trashed')->name('trashed.')->middleware('auth')->group(function() {
    Route::get('/', [TrashedPostController::class, 'index'])->name('index');
    Route::get('/{post}', [TrashedPostController::class, 'show'])->name('show')->withTrashed();
    Route::put('/{post}', [TrashedPostController::class, 'update'])->name('update')->withTrashed();
    Route::delete('/{post}', [TrashedPostController::class, 'destroy'])->name('destroy')->withTrashed();
});

require __DIR__.'/auth.php';
