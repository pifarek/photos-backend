<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PhotoResource;
use App\Http\Resources\SinglePhotoResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Http\Resources\CategoryResource;
use App\Photo;

class ApiController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function categories()
    {
        $categories = Category::orderBy('date', 'desc')->get();

        return CategoryResource::collection($categories);
    }

    /**
     * @param $category_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function photos($category_id)
    {
        $photos = Photo::where('category_id', $category_id)->get();

        return PhotoResource::collection($photos);
    }

    /**
     * @param $photo_id
     * @return PhotoResource
     */
    public function photo($photo_id)
    {
        $photo = Photo::find($photo_id);

        if(!$photo) {
            return response()->json(['data' => '']);
        }

        $prev = Photo::where('category_id', $photo->category_id)->where('id', '<', $photo->id)->orderBy('id', 'desc')->first();
        $next = Photo::where('category_id', $photo->category_id)->where('id', '>', $photo->id)->orderBy('id', 'asc')->first();

        return response()->json([
            'prev' => $prev ? new PhotoResource($prev) : null,
            'photo' => new PhotoResource($photo),
            'next' => $next ? new PhotoResource($next) : null,
        ]);
    }

    public function prev($photo_id)
    {
        $photo = Photo::find($photo_id);

        if(!$photo) {
            return response()->json(['data' => '']);
        }

        return new PhotoResource($photo);
    }

    public function next($photo_id)
    {
        $photo = Photo::find($photo_id);

        if(!$photo) {
            return response()->json(['data' => '']);
        }

        return new PhotoResource($photo);
    }

    public function random()
    {
        $photo = Photo::inRandomOrder()->limit(1)->first();

        return new PhotoResource($photo);
    }
}
