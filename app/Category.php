<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public function cover()
    {
        return Photo::where('category_id', $this->id)->orderBy('created_at', 'desc')->first();
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'category_id', 'id')->orderBy('id', 'desc');
    }

    public function delete()
    {
        // Clear are photos inside the category
        foreach($this->photos as $photo) {
            $photo->delete();
        }

        return parent::delete();
    }
}
