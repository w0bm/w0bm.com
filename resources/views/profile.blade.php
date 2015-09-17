@extends('layout')
@section('content')

    <div class="page-header">
        <h1>{{$user->username}}</h1>
        <span>Uploads: {{ $user->videos()->count() }}</span>
    </div>


@endsection
