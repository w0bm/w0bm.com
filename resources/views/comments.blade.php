@extends('profilelayout')
@section('content')
@include('partials.profileheader')
@include('partials.comlist')
<h3>Comments</h3>
<div class="row">
    <div class="col-md" id="list">
        <div class="spinner">
            <div class="cube1"></div>
            <div class="cube2"></div>
        </div>
    </div>
    <!--<div class="col-md-6" id="message"><h4>Select a comment to display content</h4></div>-->
</div>
@endsection
