<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'url_image' => $this -> url_image,
            'rating' => $this -> rating,
            'episodes' => $this -> episodes,
            'status' => $this -> status,
            'users' => $this -> whenLoaded('users'),
            'createdAt' => $this -> created_at?->toISOString(),
            'updatedAt' => $this -> updated_at?->toISOString()
        ];
    }
}
