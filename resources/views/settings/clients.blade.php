@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="page-title">
            API Clients
        </h3>

        <div class="row">
            <div class="col-md-12">
                @if($clients->count())
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Secret</th>
                            <th style="width: 0">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td>
                                    {{ $client->name }}
                                </td>
                                <td>
                                    {{ $client->secret }}
                                </td>
                                <td style="white-space:nowrap">

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                @else
                    <div class="alert alert-info">There are no defined clients.</div>
                @endif
            </div>
        </div>

    </div>
@endsection
