@extends('profilelayout')
@section('content')
 <div class="page-header">
         <h3>Privacy</h3>
 </div>

<div class="box">
<h5>What does Cloudflare log?</h5>
<p>Probably anything that is possible to log.</p>
<h5>What can we access from the Cloudflare logs?</h5>
<p>Only basic stuff like the amount of visitors and where they are from, no ips and also no chance to get the raw log files.</p>
<h5>What do we log?</h5>
<p>Anything our Nginx logs (if we are not using cloudflare) within it's logs, however there are no user-account bound ip adresses.</p>
<p>Our server creates the log in this format: <br />
<code>x.x.x.x (IP address) - - [13/Mar/37:13:37:00 -9999] (time) "GET /1337 HTTP/1.1 (method, destination & protocol) " 200 3158 (http resonse code)"-" "USER AGENT"</code></p>
<p>We value your privacy and will never give out any user data or sell user data (implying someone would really want to buy this shit anyways lol)</p>
<p>We don't want to know who you are!</p>
<h5>Why do we log?</h5>
<p>Simply to prevent the abuse of our service.</p>
<h5>3<sup>rd</sup> party links</h5>
<p>There a some 3rd party linkings on this website, be careful with clicking them we don't know whats inside the box blah blah blah, don't be stupid and don't trust the internet.</p>
<p>We also use a webfont from google fonts, if you don't like that go fuck yourself or block it with umatrix.</p>
<h5>Cookies</h5>
<p>Yes, we use cookies if you don't like that don't come to our site! (or don't accept them in the first place)</p>
</div>
@include('footer')
@endsection
