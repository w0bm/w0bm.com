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
    <link rel="icon" href="/favicon.png">
    <title>w0bm.com - WebMs with sound!</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="favicon"
      type="image/ico"
      href="favicon.ico" />
    <link rel="stylesheet" href="/css/w0bmfonts.css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="/css/w0bmcustom.css?v={{ filemtime("css/w0bmcustom.css") }}">
</head>
<body>
@include('partials.handlebars')
@if(auth()->check())
    @include('partials.filterselect')
    @if(isset($user) && auth()->user()->can('edit_user'))
        @include('partials.banmenu')
    @endif
@endif
<canvas id="bg" @if(!Session::get('background', true)) style="display: none;"@endif></canvas>

@include('partials.navigation')

<div class="wrapper">
    @yield('aside')
    <div style="width: auto; overflow: hidden; position: relative;">
        <div class="fucklaravel">
            @yield('content')
        </div>
    </div>

</div>
<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-tagsinput.min.js"></script>
<script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/js/isotope.pkgd.min.js"></script>
<script src="/js/imagesloaded.pkgd.min.js"></script>
<script src="/js/handlebars.min.js"></script>
<script src="/js/jquery.timeago.js"></script>
<script src="/js/raven.min.js"></script>
@if(env('SENTRY_PUBLIC'))
<script>
    Raven.config('{{ env("SENTRY_PUBLIC") }}').install()
</script>
@endif
<script src="/js/w0bmscript.min.js?v={{ filemtime("js/w0bmscript.min.js") }}"></script>
</body>
</html>
