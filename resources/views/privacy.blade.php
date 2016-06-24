@extends('layout')
@section('content')
<div class="page-header">
        <h2>Privacy</h2>
    </div>
<h5>What do we log?</h5>
<ul>
<li>Anything our webserver (Nginx) logs within it's logfile.</li>
<li>Information you provide while using our service this includes:</li>
<ul>
<li>Your Username</li>
<li>Your email</li>
<li>Your password</li>
<li>Your written comments</li>
<li>Your uploads</li>
</ul>
</ul>
<h5>What we don't log</h5>
<ul>
<li>Your IP in our database linked to your comments, uploads or account</li>
</ul>
<h5>Short: We do log something, but it's not easy to identify a single user just with the Nginx access log. We use the access log mainly to keep track over our traffic and for some information about the site in general. We use the command line tool "Goaccess" to parse the log.</h5>
@include('footer')
@endsection
