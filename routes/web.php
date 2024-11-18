<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//these are all the routes for CRUD
// Route::resource('posts', PostController::class)->except(['index', 'create']);
// Route::get('/product', [ProductController::class, 'index'])->name('product.index');
// Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
// Route::post('/product', [ProductController::class, 'store'])->name('product.store');
// Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
// Route::put('/product/{product}/update', [ProductController::class, 'update'])->name('product.update');
// Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

//routes for member_concern
//This method generates routes for the standard CRUD operations (Create, Read, Update, Delete) for a resource.
Route::resource('posts', PostController::class)->except(['index', 'create']);
//It defines a GET route to display the form for creating a new post
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create/user', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
