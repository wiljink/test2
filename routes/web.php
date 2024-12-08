<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\LoginMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login')->middleware(GuestMiddleware::class);

Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::resource('posts', PostController::class)->except(['index', 'create', 'update']);


Route::middleware(LoginMiddleware::class)->group(function () {

    Route::put('/posts/update', [PostController::class, 'update'])->name('posts.update');

    Route::put('/posts/analyze', [PostController::class, 'analyze'])->name('posts.analyze');

    //Route::post('/posts/save-progress', [PostController::class, 'saveProgress'])->name('posts.saveProgress');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

    Route::get('/resolved-concerns', [PostController::class, 'resolved'])->name('posts.resolved');

    Route::get('/resolved-facilitate', [PostController::class, 'facilitate'])->name('posts.facilitate');




    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');




});

Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
 //It defines a GET route to display the form for creating a new post
Route::get('/posts/create/concern', [PostController::class, 'create'])->name('posts.create');
Route::get('/posts/success', function () {
    return view('posts.thank_you');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__ . '/auth.php';
