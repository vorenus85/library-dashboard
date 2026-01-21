<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookExportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UploadController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::get('/auth/me', fn (Request $request) => response()->json($request->user()));
Route::get('/auth/check', function () {
    return response()->json([
        'authenticated' => Auth::check(),
        'user' => Auth::user(),
    ]);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/api/admin/bookCount', [DashboardController::class, 'bookCount']);
    Route::get('/api/admin/isReadRate', [DashboardController::class, 'isReadRate']);
    Route::get('/api/admin/isWishlistCount', [DashboardController::class, 'isWishlistCount']);
    Route::get('/api/admin/topGenres', [DashboardController::class, 'topGenres']);
    Route::get('/api/admin/topGenreWithName', [DashboardController::class, 'topGenreWithName']);
    Route::get('/api/admin/topAuthors', [DashboardController::class, 'topAuthors']);
    Route::get('/api/admin/wishlist', [DashboardController::class, 'wishlist']);

    Route::prefix('/api/admin/authors')->group(function(){
        Route::get('/', [AuthorController::class, 'index']);
        Route::post('/', [AuthorController::class, 'store']);
        Route::get('/{author}', [AuthorController::class, 'show']);
        Route::put('/{author}', [AuthorController::class, 'update']);
        Route::delete('/{author}', [AuthorController::class, 'destroy']);
    });

    Route::prefix("/api/admin/genres")->group(function(){
        Route::get('/', [GenreController::class, 'index']);
        Route::post('/', [GenreController::class, 'store']);
        Route::get('/{genre}', [GenreController::class, 'show']);
        Route::put('/{genre}', [GenreController::class, 'update']);
        Route::delete('/{genre}', [GenreController::class, 'destroy']);
    });

    Route::prefix("/api/admin/books")->group(function(){
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

});

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
