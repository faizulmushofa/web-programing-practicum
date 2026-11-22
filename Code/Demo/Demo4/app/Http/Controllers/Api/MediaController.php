<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/media
     */
    public function index(Request $request) : AnonymousResourceCollection
    {

        $query = Media::query();

        if ($request -> filled('title')) {
            $query -> where('title','ilike','%' . $request ->query('title') . '%');
        }

        return MediaResource::collection($query->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/media
     */
    public function store(StoreMediaRequest $request) : JsonResponse
    {
        $media = Media::create($request -> validated());

        return (new MediaResource($media))
        ->response() -> setStatusCode(201,'Media Created');
    }

    /**
     * Display the specified resource.
     * GET api/media/{media}
     */
    public function show(Media $media) : MediaResource
    {  
       return new MediaResource($media -> load('users'));
    }

    /**
     * Update the specified resource in storage.
     * PATCH /api/media/{media}
     */
    public function update(UpdateMediaRequest $request,Media $media) : MediaResource
    {
        $media -> update($request -> validated());

        return new MediaResource($media);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/media/{id}
     */
    public function destroy(Media $media) : JsonResponse
    {
        $media->delete();
        return response() -> json([
            'message' => 'Media berhasil di hapus'],201
        );
    }
}
