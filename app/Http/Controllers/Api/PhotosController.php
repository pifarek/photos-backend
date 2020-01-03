<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PhotoResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Photo;

class PhotosController extends Controller
{
    public function list($category_id)
    {
        $photos = Photo::where('category_id', $category_id)->get();

        return PhotoResource::collection($photos);
    }

    public function upload(Request $request) {

        $category_id = $request->get('category_id');
        $image = $request->file('image');

        if(!$category_id || !$image) {
            return response()->json(['status' => 'err'], 400);
        }

        $filename = uniqid(null, true) . '.jpg';

        $uploadedImage = \Image::make($image->getPathname());

        $exif = \App\Helpers\Exif::exifData($uploadedImage);

        $uploadedImage->resize(1920, null, function($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save('upload/photos/f/' . $filename);

        $uploadedImage->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save('upload/photos/s/' . $filename);

        $photo = new Photo();
        $photo->category_id = $category_id;
        $photo->filename = $filename;

        $photo->exif_make =     $exif['make'];
        $photo->exif_model =    $exif['model'];
        $photo->exif_aperture = $exif['aperture'];
        $photo->exif_iso =      $exif['iso'];
        $photo->exif_speed =    $exif['speed'];
        $photo->exif_lat =      isset($exif['coords']) ?? $exif['coords']['latitude'];
        $photo->exif_lng =      isset($exif['coords']) ?? $exif['coords']['longitude'];
        $photo->save();

        return response()->json(['status' => 'ok', 'filename' => $filename]);
    }

    /**
     * Delete selected photo
     * @param $photo_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($photo_id) {
        $photo = Photo::find($photo_id);
        if($photo) {
            $photo->delete();
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Set photo as cover
     * @param $photo_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cover($photo_id) {
        $photo = Photo::find($photo_id);
        if($photo) {
            $category_id = $photo->category_id;
            Photo::where('category_id', $category_id)->update(['is_cover' => false]);
            $photo->is_cover = true;
            $photo->save();
        }

        return response()->json(['status' => 'ok']);
    }
}
