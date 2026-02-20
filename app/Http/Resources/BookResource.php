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
            // @phpstan-ignore property.notFound
            'id' => $this->id,
            // @phpstan-ignore property.notFound
            'title' => $this->title,
            // @phpstan-ignore property.notFound
            'description' => $this->description,
            // @phpstan-ignore property.notFound
            'pages' => $this->pages,
            // @phpstan-ignore property.notFound
            'is_read' => $this->is_read,
            // @phpstan-ignore property.notFound
            'is_wishlist' => $this->is_wishlist,
            // @phpstan-ignore property.notFound
            'wishlisted_at' =>$this->wishlisted_at,
            // @phpstan-ignore property.notFound
            'image' => $this->image,
            // @phpstan-ignore property.notFound
            'image_url' => $this->image
                ? Storage::url('/uploads/'.$this->image)
                : null,
            // @phpstan-ignore property.notFound
            'author' => $this->author,
            // @phpstan-ignore property.notFound
            'genres' => $this->genres,
        ];
    }
}
