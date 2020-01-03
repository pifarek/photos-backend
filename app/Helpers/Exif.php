<?php
/**
 * Created by PhpStorm.
 * User: Marcin Piwarski
 * Date: 28.12.2019
 * Time: 21:35
 */

namespace App\Helpers;


class Exif
{
    public static function exifData($image) {
        return [
            'make' => $image->exif('Make'),
            'model' => $image->exif('Model'),
            'iso' => $image->exif('ISOSpeedRatings'),
            'speed' => $image->exif('ExposureTime'),
            'aperture' => $image->exif('FNumber')? eval('return (' . $image->exif('FNumber') . ');') : '',
            'coords' => self::gps($image->exif('GPSLatitudeRef'), $image->exif('GPSLatitude'), $image->exif('GPSLongitudeRef'), $image->exif('GPSLongitude'))
        ];
    }

    public static function gps($GPSLatitudeRef, $GPSLatitude, $GPSLongitudeRef, $GPSLongitude)
    {
        if($GPSLatitudeRef && $GPSLatitude && $GPSLongitudeRef && $GPSLongitude){
            $lat_degrees = count($GPSLatitude) > 0 ? self::gps2Num($GPSLatitude[0]) : 0;
            $lat_minutes = count($GPSLatitude) > 1 ? self::gps2Num($GPSLatitude[1]) : 0;
            $lat_seconds = count($GPSLatitude) > 2 ? self::gps2Num($GPSLatitude[2]) : 0;

            $lon_degrees = count($GPSLongitude) > 0 ? self::gps2Num($GPSLongitude[0]) : 0;
            $lon_minutes = count($GPSLongitude) > 1 ? self::gps2Num($GPSLongitude[1]) : 0;
            $lon_seconds = count($GPSLongitude) > 2 ? self::gps2Num($GPSLongitude[2]) : 0;

            $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
            $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;

            $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60*60)));
            $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60*60)));

            return array('latitude'=>$latitude, 'longitude'=>$longitude);
        }else{
            return false;
        }
    }

    private static function gps2Num($coordPart)
    {
        $parts = explode('/', $coordPart);
        if(count($parts) <= 0)
            return 0;
        if(count($parts) == 1)
            return $parts[0];
        return floatval($parts[0]) / floatval($parts[1]);
    }
}
