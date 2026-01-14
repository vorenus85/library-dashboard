<?php

namespace App\Http\Controllers;

use App\Models\Author;
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

    public function topGenreWithName() {
        $result = Genre::select('id', 'name')->withCount("books")->whereHas('books')->orderBy("books_count", "desc")->first();
        return response()->json(['topGenre' => $result]);
    }

    public function isWishlistCount(){
        $countIsWishList = Book::where('is_wishlist', true)->count();

        return response()->json(['countIsWishList' => $countIsWishList]);
    }

    public function topGenres(){
        $result = Genre::select('id', 'name')->withCount("books")->having('books_count', '>', 5)->orderBy("books_count", "desc")->get();
        return response()->json(["topGenres" => $result], 200);
    }

    public function topAuthors(){
        $result = Author::select('id', 'name')->withCount("books")->having('books_count', '>', 5)->orderBy("books_count", "desc")->get();
        return response()->json(["topAuthors" => $result], 200);
    }

    public function wishlist(){
        $wishlistedBooks = Book::with(['author:id,name'])->select('id', 'title', 'image', 'description', 'pages', 'is_read', 'is_wishlist', 'author_id')->where('is_wishlist', true)->orderBy('title', 'asc')->get();
        return response()->json($wishlistedBooks, 200);
    }

    protected function getBookCount(){
        return Book::count();
    }
}
