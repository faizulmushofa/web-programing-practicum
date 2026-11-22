<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'title',
        'url_image',
        'rating',
        'episodes',
        'status'
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
