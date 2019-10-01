@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="page-title">
            Categories

            <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary text-white">Add Category</a>
        </h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                @if($categories->count())
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th style="width: 0">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>
                                    {{ $category->name }}
                                </td>
                                <td>
                                    @if($category->date)
                                    {{ date('j F Y', strtotime($category->date)) }}
                                    @else
                                    ---
                                    @endif
                                </td>
                                <td style="white-space:nowrap">
                                    <button class="btn btn-sm btn-primary" type="button" onclick="window.location.href='{{ route('categories.edit', [$category->id]) }}'"><i class="fa fa-pencil"></i> Edit</button>
                                    <button class="btn btn-sm btn-danger" type="button" data-action="category-remove" data-id="{{ $category->id }}"><i class="fa fa-trash"></i> Remove</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {!! $categories->render() !!}
                @else
                    <div class="alert alert-info">There are no defined categories.</div>
                @endif
            </div>
        </div>

    </div>
@endsection
