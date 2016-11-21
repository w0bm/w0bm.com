<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><img src="{{ asset('logo.svg') }}" alt="w0bm.com"></a>
        </div>

        <div class=" collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="{{url('categories')}}"><i class="fa fa-bars"></i> Categories</a></li>
                <li><a href="{{url('songindex')}}"><i class="fa fa-music"></i> Songindex</a></li>
                <li><a href="{{url('irc')}}"><i class="fa fa-comment"></i> IRC</a></li>
		<li><a href="{{url('about')}}"><i class="fa fa-exclamation"></i> About</a></li>
		<li><a href="{{url('donate')}}"><img src="https://f0ck.me/b/bec7e820.png" style="height: 20px"> Support</a></li>
	    </ul>
            @if(Auth::check())
                <ul class="nav navbar-nav navbar-right">
		    <li><a href="{{url('messages')}}"><i class="fa fa-envelope"></i> <span class="badge">{{Auth::user()->messagesRecv()->unread()->count()}}</span></a></li>
                    <li><a href="#" data-toggle="modal" data-target="#filterselectmodal"><i class="fa fa-filter"></i> Filter</a></li>
                    <li><a href="{{url('upload')}}"><i class="fa fa-cloud-upload"></i> Upload</a></li>
                    <li><a href="{{url('user', Auth::user()->username)}}"><i class="fa fa-user"></i> {{Auth::user()->username}}</a></li>
                    <li><a href="{{url('logout')}}"><i class="fa fa-times"></i> Logout</a></li>
                </ul>
            @else

	<form action="{{action('UserController@login')}}" method="post" class="navbar-form navbar-right">
		<div class="form-group dropdown">
	{!! csrf_field() !!}
		  <a class="futter logreg" href="" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			    Login/Register
		  </a>
				  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				    <li role="seperator" class="trennelement"></li>
				    <li><input type="text" name="identifier" placeholder="Username/Email" class="eingabe"></li>
				    <li><input type="password" name="password" placeholder="Password" class="eingabe"></li>
				    <li><button type="submit" class="btnlogin btn-primary">Login</button> <input class="cheggbogs" type="checkbox" name="remember"><span class="erinnerung">  Remember me</span></li>
				    <li role="separator" class="divider"></li>
				    <li class=""><a href="/register">Registration status: <span class="label label-danger">Closed</span></a></li>
				  </ul>
		</div>
	</form>
            @endif
        </div>
    </div>
</nav>
