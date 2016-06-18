<!doctype html>
<html lang="de">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width,initial-scale=1">
    <meta charset="UTF-8">
    <meta name="_token" content="{{csrf_token()}}">
    <link rel="icon" href="/favicon.png">
    <title>w0bm.com - WebMs with sound!</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/jquery.mCustomScrollbar.min.css">
    <link rel="favicon" 
      type="image/ico" 
      href="favicon.ico" />
    <link href="//fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="/css/w0bmcustom.css">
</head>
<body>
@if(auth()->check())
    @include('partials.filterselect')
    @if(isset($video) && (auth()->user()->can('edit_video') || auth()->user()->id == $video->user_id))
        @include('partials.frontendedit')
    @endif
@endif
<canvas id="bg" @if(!Session::get('background', true)) style="display: none; visibility: hidden;"@endif></canvas>

@include('partials.navigation')

<div class="wrapper">
    @yield('aside')
    <div style="width: auto; overflow: hidden; position: relative;">
        <div class=" container">
            @yield('content')
        </div>
        @include('partials.flash')
    </div>
</div>

<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/js/isotope.pkgd.min.js"></script>
<script src="/js/imagesloaded.pkgd.min.js"></script>
<script src="/js/jquery.timeago.js"></script>
<script src="/js/bootstrap-tagsinput.min.js"></script>
<script src="/js/w0bmscript.js"></script>
</body>
</html>
