@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="page-title">Edit Category</h3>

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
                <div class="card">
                    <div class="card-header">
                        Category
                    </div>

                    <form class="p-4" method="post" action="{{ route('categories.update', [$category->id]) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="category-name">Name</label>
                            <input type="text" name="name" class="form-control" id="category-name" placeholder="Category Name" value="{{ old('name', $category->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="category-date">Date</label>
                            <input type="text" name="date" class="form-control datepicker" id="category-date" placeholder="Category Date" value="{{ old('date', $category->date? date('d/m/Y', strtotime($category->date)) : '') }}">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Edit Category</button>
                            <button class="btn btn-danger" onclick="window.location.href='{{ route('categories.index') }}'" type="button">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
