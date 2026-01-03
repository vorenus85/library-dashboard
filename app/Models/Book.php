<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',
        'publised_year',
        'isbn',
        'image',
        'pages',
        'description',
        'is_read',
        'is_wishlist'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_wishlist' => 'boolean',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

}
