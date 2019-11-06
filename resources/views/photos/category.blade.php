@extends('layouts.app')

@section('content')
    <div class="container" id="page-photos-category">
        <h3 class="page-title">
            {{ $category->name }}
            <a href="{{ route('photos.create', ['category_id' => $category->id]) }}" class="btn btn-sm btn-primary text-white">Add Photo</a>
        </h3>

        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        @if($category->photos->count())
            <div class="row">
                @foreach($category->photos as $photo)
                    <div class="photo-container col-md-4 mb-4">
                        <div class="photo" data-id="{{ $photo->id }}">
                            <a href="{{ route('photos.edit', ['photo_id' => $photo->id]) }}">
                                @if($photo->filename)
                                <img src="{{ url('upload/photos/s/' . $photo->filename) }}" class="img-thumbnail rounded" alt="">
                                @else
                                <img src="{{ url('assets/images/no_image.jpg') }}" class="img-thumbnail rounded" alt="">
                                @endif
                            </a>

                            @if(!$photo->is_cover)
                            <a href="#" class="btn btn-sm btn-primary" data-action="cover"><i class="fa fa-image"></i> Make it cover</a>
                            @endif
                            <a href="#" class="btn btn-sm btn-danger" data-action="remove"><i class="fa fa-trash"></i> Remove</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif


            <div class="row category-empty{{ $category->photos->count()? ' d-none' : '' }}">
                <div class="col-md-12">
                    <div class="alert alert-warning">We don't have any photos uploaded to the selected category.</div>
                </div>
            </div>

    </div>
@endsection
