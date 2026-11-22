<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BookResource;

// TODO 7: Lengkapi Resource ini agar menampilkan data Member
// beserta daftar buku yang sedang dipinjam (relasi 'books').
//
// Gunakan BookResource.php sebagai contoh format penulisan.

class MemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'books' => BookResource::collection($this->whenLoaded('books')),
        ];
    }
}
