<?php

namespace App\Http\Controllers;

use App\Category;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    public function index()
    {
        // Get the categories
        $categories = Category::orderBy('date', 'desc')->get();

        return view('photos.index', ['categories' => $categories]);
    }

    /**
     * Display photos inside category
     * @param int $category_id
     */
    public function category(int $category_id)
    {
        $category = Category::find($category_id);
        if(!$category) {
            return redirect()->route('photos.index');
        }

        return view('photos.category', ['category' => $category]);
    }

    public function create(Request $request)
    {
        $category_id = $request->get('category_id', null);
        $categories = Category::orderBy('created_at', 'desc')->get();

        return view('photos.create', ['categories' => $categories, 'category_id' => $category_id]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required', 'exists:categories,id'],
            'temporary-image' => ['required', 'temporary_image']
        ]);

        $filename = uniqid(null, true) . '.jpg';

        $uploadedImage = \Image::make('upload/temporary/' . $request->get('temporary-image'));
        $uploadedImage->save('upload/photos/f/' . $filename);
        $uploadedImage->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save('upload/photos/s/' . $filename);

        \File::delete('upload/temporary/' . $request->get('temporary-image'));

        $photo = new Photo();
        $photo->category_id = $request->get('category');
        $photo->filename = $filename;
        $photo->exif_make = $request->get('exif_make');
        $photo->exif_model = $request->get('exif_model');
        $photo->exif_aperture = $request->get('exif_aperture');
        $photo->exif_iso = $request->get('exif_iso');
        $photo->exif_speed = $request->get('exif_speed');
        $photo->exif_lat = $request->get('exif_lat');
        $photo->exif_lng = $request->get('exif_lng');
        $photo->save();

        return redirect()->route('photos.index', ['category_id' => $photo->category_id])->with('success', 'Photo has been uploaded successfully.');
    }

    public function edit($photo_id)
    {
        $photo = Photo::find($photo_id);
        if(!$photo) {
            return redirect()->route('photos.index');
        }

        $categories = Category::orderBy('created_at', 'desc')->get();

        return view('photos.edit', ['photo' => $photo, 'categories' => $categories]);
    }

    public function update(Request $request, $photo_id)
    {
        $photo = Photo::find($photo_id);

        $request->validate([
            'category' => ['required', 'exists:categories,id'],
            'temporary-image' => ['temporary_image']
        ]);

        if($request->get('temporary-image')) {
            $filename = uniqid(null, true) . '.jpg';

            $uploadedImage = \Image::make('upload/temporary/' . $request->get('temporary-image'));
            $uploadedImage->save('upload/photos/f/' . $filename);
            $uploadedImage->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save('upload/photos/s/' . $filename);
        }

        $photo->category_id = $request->get('category');
        if($request->get('temporary-image')) {
            $photo->filename = $filename;
        }
        $photo->exif_make = $request->get('exif_make');
        $photo->exif_model = $request->get('exif_model');
        $photo->exif_aperture = $request->get('exif_aperture');
        $photo->exif_iso = $request->get('exif_iso');
        $photo->exif_speed = $request->get('exif_speed');
        $photo->exif_lat = $request->get('exif_lat');
        $photo->exif_lng = $request->get('exif_lng');
        $photo->save();

        return redirect()->route('photos.index', ['category_id' => $photo->category_id])->with('success', 'Selected photo has been updated successfully');
    }

    public function temporary(Request $request) {

        $validation = \Validator::make($request->all(), [
            'image' => ['required', 'image', 'max:4000000']
        ]);

        if($validation->fails()) {
            return response()->json(['status' => 'err']);
        }

        $file = $request->file('image');

        $filename = uniqid(false, true) . '.jpg';

        $image = \Image::make($file->getPathname())->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $exif = $this->exifData($image);

        $image->save('upload/temporary/' . $filename);

        return response()->json(['status' => 'ok', 'filename' => $filename, 'exif' => $exif]);
    }

    public function remove($photo_id)
    {
        $photo = Photo::find($photo_id);
        if(!$photo) {
            return response()->json(['status' => 'err']);
        }

        $photo->delete();

        return response()->json(['status' => 'ok']);
    }

    /**
     * @param int $photo_id photo id
     */
    public function cover(int $photo_id)
    {
        $photo = Photo::find($photo_id);
        if($photo) {
            $category_id = $photo->category_id;

            Photo::where('category_id', $category_id)->update(['is_cover' => false]);

            $photo->is_cover = true;
            $photo->save();
        }

        return response()->json(['status' => 'ok']);
    }

    private function exifData($image) {
        return [
            'make' => $image->exif('Make'),
            'model' => $image->exif('Model'),
            'iso' => $image->exif('ISOSpeedRatings'),
            'speed' => $image->exif('ExposureTime'),
            'aperture' => $image->exif('FNumber')? eval('return (' . $image->exif('FNumber') . ');') : '',
            'coords' => $this->gps($image->exif('GPSLatitudeRef'), $image->exif('GPSLatitude'), $image->exif('GPSLongitudeRef'), $image->exif('GPSLongitude'))
        ];
    }

    private function gps($GPSLatitudeRef, $GPSLatitude, $GPSLongitudeRef, $GPSLongitude)
    {
        if($GPSLatitudeRef && $GPSLatitude && $GPSLongitudeRef && $GPSLongitude){
            $lat_degrees = count($GPSLatitude) > 0 ? $this->gps2Num($GPSLatitude[0]) : 0;
            $lat_minutes = count($GPSLatitude) > 1 ? $this->gps2Num($GPSLatitude[1]) : 0;
            $lat_seconds = count($GPSLatitude) > 2 ? $this->gps2Num($GPSLatitude[2]) : 0;

            $lon_degrees = count($GPSLongitude) > 0 ? $this->gps2Num($GPSLongitude[0]) : 0;
            $lon_minutes = count($GPSLongitude) > 1 ? $this->gps2Num($GPSLongitude[1]) : 0;
            $lon_seconds = count($GPSLongitude) > 2 ? $this->gps2Num($GPSLongitude[2]) : 0;

            $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
            $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;

            $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60*60)));
            $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60*60)));

            return array('latitude'=>$latitude, 'longitude'=>$longitude);
        }else{
            return false;
        }
    }

    private function gps2Num($coordPart)
    {
        $parts = explode('/', $coordPart);
        if(count($parts) <= 0)
            return 0;
        if(count($parts) == 1)
            return $parts[0];
        return floatval($parts[0]) / floatval($parts[1]);
    }
}
