<!doctype html>
<html lang="de">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"">
    <meta name="viewport"
          content="width=device-width,initial-scale=1">
    <meta charset="UTF-8">
    <title>w0b me</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/cyborg/bootstrap.min.css">
    <style>
        body {
            padding-bottom: 70px;
        }
        .flashcontainer {
            position:fixed;
            margin:0 auto;
            left:0;
            right:0;
            bottom:100px;
            opacity: 0.8;
        }
        .flashcontainer:empty {
            display:none;
        }
        .navbar{
            min-height:20px;
        }
    </style>
</head>
<body>

<div class="container">
    @yield('content')
</div>

<nav class="navbar navbar-inverse navbar-fixed-bottom">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">w0bm</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="categories">Categories</a></li>
                <li><a href="about">About</a></li>
                <li><a href="songindex">Songindex</a></li>
            </ul>
            @if(Auth::check())
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="upload">Upload</a></li>
                    <li><a href="user/{{Auth::user()->username}}">{{Auth::user()->username}}</a></li>
                    <li><a href="logout">Logout</a></li>
                </ul>
            @else
                <form action="login" method="post" class="navbar-form navbar-right">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="text" name="identifier" placeholder="Username/Email" class="form-control">
                        <input type="password" name="password" placeholder="Password" class="form-control">
                        <input type="checkbox" name="remember">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <a href="register" class="btn btn-success">Register</a>
                    </div>
                </form>
            @endif
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
@include('partials.flash')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>
    var video = $('video');
    video.prop('volume', 0.3);
    video.get(0).play();
</script>
</body>
</html>
