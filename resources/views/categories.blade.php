@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Categories</h1>
    </div>
    <div class="row">
        @foreach($categories as $category)
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="{{ asset('/images/cat/' . $category->shortname . '.png') }}" alt="{{$category->name}}">
                    <div class="caption">
                        <h3>{{$category->name}}</h3>
                        <p>{{$category->description}}</p>
                        <p><a href="{{$category->shortname}}" class="btn btn-primary" role="button">View</a></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection