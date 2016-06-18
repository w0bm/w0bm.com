@extends('profilelayout')
@section('content')
	<div class="page-header">
        <h1>Messages</h1>
    </div>
    <button class="btn btn-primary pull-right" id="read-all">Mark all as read</button>
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
