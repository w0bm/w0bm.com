<!doctype html>
<html lang="de">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#161618">
    <meta name="viewport"
          content="width=device-width,initial-scale=1">
    <meta charset="UTF-8">
    <meta name="_token" content="{{csrf_token()}}">
    <meta name="keywords" content="Random WebMs, WebMs, Internet Videos">
    <meta name="Description" content="Tags:@if(isset($video)) {{ $video->getTagListAttribute() }} @endif">
    <meta property="og:site_name" content="w0bm.com" />
    <meta property="og:title" content="@if(!empty($video->interpret)){{$video->interpret}} – {{$video->songtitle}}@else() NO DATA AVAILABLE ;__; @endif">
    <meta property="og:description" content="Tags:@if(isset($video)) {{ $video->getTagListAttribute() }} @endif">
    <meta property="og:image" content="@if(isset($video))https://w0bm.com/thumbs/{{str_replace(".webm","",$video->file)}}.gif"@endif/>
    <meta property="og:video" content="@if(isset($video))https://b.w0bm.com/{{ $video->file }} @endif">
    <meta property="og:url" content="@if(isset($video))https://w0bm.com/{{ $video->id }}@endif">
    <meta property="og:video:secure_url" content="@if(isset($video))https://b.w0bm.com/{{ $video->file }} @endif">
    <meta property="og:video:type" content="video/webm">
    <link rel="icon" href="/favicon.png">
    <title>@if(isset($video)){{ $video->id }} -@endif w0bm.com</title>
    <link rel="favicon" href="favicon.ico" type="image/ico">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="/css/w0bmfonts.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="/css/video-js.min.css">
    <link rel="stylesheet" href="/css/w0bmcustom.css?v={{ filemtime("css/w0bmcustom.css") }}">
    <link rel="stylesheet" href="/css/vjsnew.css?v=1.1.1">
</head>
<body>
@if(auth()->check())
    @include('partials.filterselect')
    @if(isset($video) && (auth()->user()->can('edit_video') || auth()->user()->id == $video->user_id))
        @include('partials.frontendedit')
	@endif
@endif
<canvas class="hidden-xs" id="bg"></canvas>

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
<script src="/js/bootstrap-tagsinput.min.js"></script>
<script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/js/isotope.pkgd.min.js"></script>
<script src="/js/imagesloaded.pkgd.min.js"></script>
<script src="/js/jquery.timeago.js"></script>
<script src="/js/jquery.detectmobilebrowser.js"></script>
<script src="/js/video.min.js"></script>
<script src="/js/raven.min.js"></script>
@if(env('SENTRY_PUBLIC'))
<script>
    Raven.config('{{ env("SENTRY_PUBLIC") }}').install()
</script>
@endif
<script src="/js/w0bmscript.min.js?v={{ filemtime("js/w0bmscript.min.js") }}"></script>
</body>
</html>
