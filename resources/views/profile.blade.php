@extends('layout')
@section('content')

    <div class="page-header">
        <h1>{{$user->username}} <small>{{ $user->videos()->count() }} uploads</small></h1>
    </div>


@endsection
