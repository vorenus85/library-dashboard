<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookExportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\WishlistController;



Route::get('/bookCount', [DashboardController::class, 'bookCount']);
Route::get('/isReadRate', [DashboardController::class, 'isReadRate']);
Route::get('/isWishlistCount', [DashboardController::class, 'isWishlistCount']);
Route::get('/topGenres', [DashboardController::class, 'topGenres']);
Route::get('/topAuthors', [DashboardController::class, 'topAuthors']);
Route::get('/wishlist', [DashboardController::class, 'wishlist']);

Route::prefix('/authors')->group(function(){
    Route::get('/', [AuthorController::class, 'index']);
    Route::post('/', [AuthorController::class, 'store']);
    Route::get('/{author}', [AuthorController::class, 'show']);
    Route::put('/{author}', [AuthorController::class, 'update']);
    Route::delete('/{author}', [AuthorController::class, 'destroy']);
});

Route::prefix("/genres")->group(function(){
    Route::get('/', [GenreController::class, 'index']);
    Route::post('/', [GenreController::class, 'store']);
    Route::get('/{genre}', [GenreController::class, 'show']);
    Route::put('/{genre}', [GenreController::class, 'update']);
    Route::delete('/{genre}', [GenreController::class, 'destroy']);
});

Route::prefix("/books")->group(function(){
    Route::get('/', [BookController::class, 'index']);
    Route::post('/', [BookController::class, 'store']);
    Route::get('/export', [BookExportController::class, 'export']);
    Route::get('/{book}', [BookController::class, 'show']);
    Route::put('/{book}', [BookController::class, 'update']);

    Route::patch('/{book}/toggle-read', [BookController::class, 'toggleRead']);
    Route::patch('/{book}/toggle-wishlist', [BookController::class, 'toggleWishlist']);
    Route::delete('/{book}', [BookController::class, 'destroy']);

    Route::post('/image/upload', [UploadController::class, 'store']);
    Route::delete('/image/delete/{book}', [UploadController::class, 'delete']);
});
