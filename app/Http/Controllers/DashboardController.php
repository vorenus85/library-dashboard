<?php

namespace App\Http\Controllers;

use App\Models\Book;
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

    protected function getBookCount(){
        return Book::count();
    }
}
