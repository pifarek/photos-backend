<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Photos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('category_id')->nullable()->default(null);
            $table->string('filename')->nullable();
            $table->string('exif_make')->nullable();
            $table->string('exif_model')->nullable();
            $table->string('exif_aperture')->nullable();
            $table->string('exif_iso')->nullable();
            $table->string('exif_speed')->nullable();
            $table->string('exif_lat')->nullable();
            $table->string('exif_lng')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
