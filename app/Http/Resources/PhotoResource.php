<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' =>             $this->id,
            'categoryId' =>     $this->category_id,
            "filename" =>       $this->filename,
            'isCover' =>        (bool) $this->is_cover,
            "exifMake" =>       $this->exif_make,
            "exifModel" =>      $this->exif_model,
            "exifAperture" =>   $this->exif_aperture,
            "exifIso" =>        $this->exif_iso,
            "exifSpeed" =>      $this->exif_speed,
            "exifLat" =>        $this->exif_lat,
            "exifLng" =>        $this->exif_lng,
            'category' =>       $this->category
        ];
    }
}
