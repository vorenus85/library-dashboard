<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index']);

Route::get('/authors', [AuthorController::class, 'index']);
Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);

Route::get('/genres', [GenreController::class, 'index']);
Route::delete('/genres/{genre}', [GenreController::class, 'destroy']);
