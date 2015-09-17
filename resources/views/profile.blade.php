@extends('layout')
@section('content')

    <div class="page-header">
        <h1>{{$user->username}} <small>Uploads: {{ $user->videos()->count() }}</small></h1>
    </div>


@endsection
