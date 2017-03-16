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
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="favicon"
      type="image/ico"
      href="favicon.ico" />
    <link href="//fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=UnifrakturCook:700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="{{ asset('css/w0bmcustom.css') }}?v=1.0.67">
<!-- Piwik -->
<script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(["setDomains", ["*.w0bm.com"]]);
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="//stats.w0bm.com/";
        _paq.push(['setTrackerUrl', u+'js']);
        _paq.push(['setSiteId', '1']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'js'; s.parentNode.insertBefore(g,s);
    })();
</script>
<!-- End Piwik Code -->
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
@include('partials.flash')
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
<script src="/js/w0bmscript.js?v=1.1.15"></script>
</body>
</html>
