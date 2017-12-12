@extends('profilelayout')
@section('content')
@include('partials.msglist')
	<div class="page-header">
        <h3>Messages</h3>
    </div>
    <div class="">
        <div class="col-md-6" id="list">
            <div class="spinner">
                <div class="cube1"></div>
                <div class="cube2"></div>
            </div>
        </div>
        <div class="col-md-6" id="message"><h4>Select a message to display content</h4></div>
    </div>
@endsection
