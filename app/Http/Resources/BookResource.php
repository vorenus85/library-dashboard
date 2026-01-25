<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'pages' => $this->pages,
            'is_read' => $this->is_read,
            'is_wishlist' => $this->is_wishlist,
            'wishlisted_at' =>$this->wishlisted_at,
            'image' => $this->image,
            'image_url' => $this->image
                ? Storage::url('/uploads/'.$this->image)
                : null,

            'author' => $this->author,
            'genres' => $this->genres,
        ];
    }
}
