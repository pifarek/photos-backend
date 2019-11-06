@extends('layouts.app')

@section('content')
    <div class="container" id="page-photos-index">
        <h3 class="page-title">Photos</h3>

        @if($categories->count())
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-4 mb-4">
                        <a href="{{ route('photos.category', $category->id) }}" class="text-dark text-decoration-none">
                            <div class="card">
                                @if($category->cover())
                                <img src="{{ url('upload/photos/s/' . $category->cover()->filename) }}" class="card-img-top" alt="{{ $category->name }}">
                                @else
                                <img src="{{ url('assets/images/no_image.jpg') }}" class="card-img-top" alt="{{ $category->name }}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $category->name }}</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning">We don't have any categories defined.</div>
                </div>
            </div>
        @endif
        <div class="row">

        </div>

    </div>
@endsection
