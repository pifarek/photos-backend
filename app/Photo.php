<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';

    public function delete()
    {
        \File::delete('upload/photos/f/' . $this->filename);
        \File::delete('upload/photos/s/' . $this->filename);
        return parent::delete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function next()
    {
        return Photo::where('category_id', $this->category_id)->where('id', '>', $this->id)->orderBy('id', 'desc')->first();
    }

    public function previous()
    {
        return Photo::where('category_id', $this->category_id)->where('id', '<', $this->id)->orderBy('id', 'desc')->first();
    }
}
