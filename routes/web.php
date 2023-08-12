<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
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
    Route::post('/profile-add-image', [ProfileController::class, 'UploadImage']);
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function(){
    Route::get('/post',[App\Http\Controllers\PostController::class,"index"])->name('posts.index');
    Route::get('/post/create',[App\Http\Controllers\PostController::class,"create"]);
    Route::get('/post/{id}',[App\Http\Controllers\PostController::class,"show"]);
    Route::post('/post',[App\Http\Controllers\PostController::class,"store"]);
    Route::delete('/post/{id}',[App\Http\Controllers\PostController::class,"destroy"]);
    Route::get('/post/{id}/edit',[App\Http\Controllers\PostController::class,"edit"]);
    Route::put('/post/{id}',[App\Http\Controllers\PostController::class,"update"]);
    Route::post('/comments',[App\Http\Controllers\CommentController::class,"store"]);
    Route::delete('/comments/delete',[App\Http\Controllers\CommentController::class,"destroy"]);
    Route::post('/comments/edit',[App\Http\Controllers\CommentController::class,"update"]);
    Route::post('/reactions',[App\Http\Controllers\ReactionsController::class,"store"]);
});


Route::get('/demo',function () {return view('posts.demo');});
Route::get('/test',function () {return view('posts.test');});

Route::get('/auth/github/redirect', [AuthController::class, 'redirectToGitHub']);
Route::get('/auth/github/callback', [AuthController::class, 'handleGitHubCallback']);

Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);


