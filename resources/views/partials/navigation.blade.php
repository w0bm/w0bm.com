<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
		<img src="{{ asset('logo.svg') }}" alt="w0bm.com">
		<img src="/muetze.png" alt="christmas">
	    </a>
        </div>

        <div class=" collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="{{url('categories')}}"><i class="fa fa-bars"></i> Categories</a></li>
                <li><a href="{{url('index')}}"><i class="fa fa-list"></i> Index</a></li>
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
		<!-- Hier war mal der Login Kot -->
		<ul class="nav navbar-nav navbar-right">
		<li><a href="#" data-toggle="modal" data-target="#loginmodal"><i class="fa fa-cube"></i> Login</a></li>
		@include('partials.loginmodal')
		</ul>
            @endif
        </div>
    </div>
</nav>
