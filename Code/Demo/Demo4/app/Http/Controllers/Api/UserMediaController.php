<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserMediaController extends Controller
{
    //GET API /api/user/{user}/media
    public function index(User $user) : AnonymousResourceCollection{
        return MediaResource::collection($user->media()->paginate(10));
    }

    //POST API /api/{user}/media/{media}
    public function store(User $user,Media $media) : JsonResponse{
       
    if($user -> media() ->where('media_id',$media -> id) -> exists()){
            return response() -> json([
                'message' => 'Media sudah ada di dalam koleksi User'
            ],409); 
        }

        $user -> media()->attach($media -> id);

        return response() -> json(
            [
                'message'=> 'Media Berhasil di tambahkan ke koleksi user'
            ],200
        );
    }

    //DELETE API /api/{user}/media/{media}

    public function detach(User $user,Media $media) : JsonResponse{
        $user -> media() -> detach($media -> id);

        return response() -> json(
            [
                "message" => 'Media berhasil di hapus dari koleksi user'
            ],200
        );
    }
}
