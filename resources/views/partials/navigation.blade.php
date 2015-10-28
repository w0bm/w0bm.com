<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><img src="{{ asset('logo.svg') }}"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="{{url('categories')}}">Categories</a></li>
                {{--<li><a href="about">About</a></li>--}}
                <li><a href="{{url('songindex')}}">Songindex</a></li>
                <li><a href="{{url('togglebackground')}}" id="togglebg"><i class="fa fa-toggle-off"></i> Background</a></li>
            </ul>
            @if(Auth::check())
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{url('upload')}}">Upload</a></li>
                    <li><a href="{{url('user', Auth::user()->username)}}">{{Auth::user()->username}}</a></li>
                    <li><a href="{{url('logout')}}">Logout</a></li>
                </ul>
            @else
                <form action="{{action('UserController@login')}}" method="post" class="navbar-form navbar-right">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="text" name="identifier" placeholder="Username/Email" class="form-control">
                        <input type="password" name="password" placeholder="Password" class="form-control">
                        <input type="checkbox" name="remember">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <a href="{{url('register')}}" class="btn btn-success">Register</a>
                    </div>
                </form>
            @endif
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
