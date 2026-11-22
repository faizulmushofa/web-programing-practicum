<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder{
    public function run() : void{
         $items = [
            [
                'title'     => 'One Piece',
                'url_image' => 'https://media.kitsu.app/anime/poster_images/12/medium.jpg',
                'rating'    => 86.4,
                'episodes'  => 1100,
                'status'    => 'current',
            ],
            [
                'title'     => 'Attack on Titan',
                'url_image' => 'https://media.kitsu.app/anime/poster_images/7442/medium.jpg',
                'rating'    => 87.2,
                'episodes'  => 87,
                'status'    => 'finished',
            ],
            [
                'title'     => 'Jujutsu Kaisen',
                'url_image' => 'https://media.kitsu.app/anime/poster_images/42765/medium.jpg',
                'rating'    => 85.1,
                'episodes'  => 24,
                'status'    => 'finished',
            ],
            [
                'title'     => "Frieren: Beyond Journey's End",
                'url_image' => 'https://media.kitsu.app/anime/poster_images/46474/medium.jpg',
                'rating'    => 91.5,
                'episodes'  => 28,
                'status'    => 'finished',
            ],
            [
                'title'     => 'Spirited Away',
                'url_image' => 'https://media.kitsu.app/anime/poster_images/176/medium.jpg',
                'rating'    => 89.0,
                'episodes'  => 1,
                'status'    => 'finished',
            ],
            [
                'title'     => 'Demon Slayer',
                'url_image' => 'https://media.kitsu.app/anime/poster_images/41370/medium.jpg',
                'rating'    => 84.3,
                'episodes'  => 26,
                'status'    => 'finished',
            ],
        ];
        
        foreach ($items as $item) {
           Media::firstOrCreate(['title' => $item['title']],$item);
        }
    }
}