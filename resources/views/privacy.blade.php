@extends('profilelayout')
@section('content')
<h5>What do we log?</h5>
<ul>
<li>Anything NGINX logs</li>
<code>
    log_format main  '$remote_addr - $remote_user [$time_local] "$request" '<br />
                      '$status $body_bytes_sent "$http_referer" '<br />
		      '"$http_user_agent" "$http_x_forwarded_for"';<br/>
</code>
<i>We keep the logs as long as we don't run out of space, if we run out of space the logs are the first thing that goes to the trash</i>
<p><b>We do not use any tracking cookies or analytics services!</b></p>
@include('footer')
@endsection
