@extends('profilelayout')
@section('content')
@include('partials.msglist')
	<div class="page-header">
        <h1>Messages</h1>
    </div>
    <div class="row">
        <div class="col-md-6" id="list">
            <div class="spinner">
                <div class="cube1"></div>
                <div class="cube2"></div>
            </div>
        </div>
        <div class="col-md-6" id="message"><h4>Select a message to display content</h4></div>
    </div>
@endsection
