<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index']);

// todo route group
Route::get('/authors', [AuthorController::class, 'index']);
Route::post('/authors', [AuthorController::class, 'store']);
Route::get('/authors/{author}', [AuthorController::class, 'show']);
Route::put('/authors/{author}', [AuthorController::class, 'update']);
Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);

// todo route group
Route::get('/genres', [GenreController::class, 'index']);
Route::post('/genres', [GenreController::class, 'store']);
Route::get('/genres/{genre}', [GenreController::class, 'show']);
Route::put('/genres/{genre}', [GenreController::class, 'update']);
Route::delete('/genres/{genre}', [GenreController::class, 'destroy']);

// todo route group
Route::get('/books', [BookController::class, 'index']);
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{book}', [BookController::class, 'show']);
Route::put('/books/{book}', [BookController::class, 'update']);
Route::patch('/books/{book}/toggle-read', [BookController::class, 'toggleRead']);
Route::patch('/books/{book}/toggle-wishlist', [BookController::class, 'toggleWishlist']);
Route::delete('/books/{book}', [BookController::class, 'destroy']);
