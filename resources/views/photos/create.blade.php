@extends('layouts.app')

@section('content')
    <div class="container" id="page-photos-create">
        <h3 class="page-title">Create Photo</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">

                <form class="p-4" method="post" action="{{ route('photos.store') }}" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <input type="hidden" name="temporary-image" value="">
                    <div class="card mb-4">
                        <div class="card-header">
                            Preview
                        </div>

                        <div class="p-4">
                            <div class="image">
                                <div class="image-preview"></div>

                                <div class="controls">
                                    <span role="button" class="fileinput-button btn btn-sm btn-success text-white" role="button">
                                        <i class="fa fa-plus"></i> Upload Image
                                        <input type="file" name="image" data-url="{{ route('photos.temporary') }}">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            Photo
                        </div>

                        <div class="p-4">
                            <div class="form-group">
                                <label for="photo-category">Category</label>
                                @if($categories->count())
                                <select name="category" class="form-control" id="photo-category">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}"{!! $category->id == old('category', $category_id)? ' selected="selected"' : '' !!}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>
                    </div>


                        <div class="card mb-4">
                            <div class="card-header">
                                <a class="text-decoration-none text-dark" data-toggle="collapse" href="#collapseInfo" role="button" aria-expanded="false" aria-controls="collapseInfo">
                                    <h5 class="mb-0">
                                        Additional Information <i class="fa fa-angle-down float-right"></i>
                                    </h5>
                                </a>
                            </div>

                            <div class="collapse" id="collapseInfo">
                                <div class="p-4">
                                    <div class="form-group">
                                        <label for="exif_make">Make</label>
                                        <input type="text" name="exif_make" id="exif_make" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="exif_model">Model</label>
                                        <input type="text" name="exif_model" id="exif_model" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="exif_iso">ISO</label>
                                        <input type="text" name="exif_iso" id="exif_iso" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="exif_speed">Shutter Speed</label>
                                        <input type="text" name="exif_speed" id="exif_speed" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="exif_aperture">Aperture</label>
                                        <input type="text" name="exif_aperture" id="exif_aperture" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="exif_lat">Lat</label>
                                        <input type="text" name="exif_lat" id="exif_lat" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="exif_lng">Lng</label>
                                        <input type="text" name="exif_lng" id="exif_lng" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>


                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Add Photo</button>
                        <button class="btn btn-danger" onclick="window.location.href='{{ route('photos.index') }}'" type="button">Cancel</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
