<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    //
    public function index(){
        $wishlistedBooks = Book::with(['author:id,name'])->select('id', 'title', 'image', 'description', 'pages', 'is_read', 'is_wishlist', 'author_id')->where('is_wishlist', true)->orderBy('title', 'asc')->get();
        return response()->json($wishlistedBooks, 200);
    }
}
