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
            'id' => $this->id,
            'category_id' => $this->category_id,
            "filename" => $this->filename,
            "exif_make" => $this->exif_make,
            "exif_model" => $this->exif_model,
            "exif_aperture" => $this->exif_aperture,
            "exif_iso" => $this->exif_iso,
            "exif_speed" => $this->exif_speed,
            "exif_lat" => $this->exif_lat,
            "exif_lng" => $this->exif_lng,
            'category' => $this->category
        ];
    }
}
