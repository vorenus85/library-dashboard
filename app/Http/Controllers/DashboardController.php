<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function bookCount() {
        $bookCount = $this->getBookCount();

        return response()->json(['bookCount' => $bookCount]);
    }

    public function isReadRate(){
        $bookCount = $this->getBookCount();
        $countIsRead = Book::where('is_read', true)->count();
        $countIsReadRate = round((($countIsRead / $bookCount) * 100), 0);

        return response()->json(['countIsRead' => $countIsRead, 'countIsReadRate' => $countIsReadRate]);

    }

    public function isWishlistCount(){
        $countIsWishList = Book::where('is_wishlist', true)->count();

        return response()->json(['countIsWishList' => $countIsWishList]);
    }

    public function genreDistribution(){
        $result = Genre::select('id', 'name')->withCount("books")->having('books_count', '>', 0)->orderBy("books_count", "desc")->get();
        return response()->json(["genreDistribution" => $result], 200);
    }

    protected function getBookCount(){
        return Book::count();
    }
}
