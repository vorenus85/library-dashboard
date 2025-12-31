<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index']);

Route::get('/authors', [AuthorController::class, 'index']);

Route::get('/genres', [GenreController::class, 'index']);
