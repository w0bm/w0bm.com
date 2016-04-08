@extends('layout')
@section('content')
<style>
html body {
     animation: anfall 0.2s;
     -webkit-animation: anfall 0.2s;
     animation-iteration-count: infinite;
     margin: 0;
     padding: 0;
     height: 100%;
     overflow: hidden;
 }

@keyframes anfall {
    0%   {background: red;}
    25%  {background: yellow;}
    50%  {background: blue;}
    75%  {background: pink;}
    100% {background: red;}
}

@-webkit-keyframes anfall {
    0%   {background: black;}
    25%  {background: white;}
    50%  {background: black;}
    75%  {background: white;}
    100% {background: black;}
}

div.a {
width: 50px;
height:50px;
}
@endsection
