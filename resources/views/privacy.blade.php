@extends('profilelayout')
@section('content')
<div class="page-header">
        <h3>Privacy</h3>
    </div>
<h5>What do we log?</h5>
<ul>
<li>Anything our webserver (Nginx) and Piwik logs within it's logfiles.</li>
<li>Information you provide while using our service this includes:</li>
<ul>
<li>Your Username</li>
<li>Your email</li>
<li>Your password</li>
<li>Your written comments</li>
<li>Your uploads</li>
</ul>
</ul>
</ul>
<h6>We use Piwik to monitor activities on our website, if you don't want to be tracked, please untick the checkbox down below.</h6>
<iframe style="border: 0; height: 150px; width: 800px;" src="https://stats.w0bm.com/index.php?module=CoreAdminHome&action=optOut&language=en"></iframe>
@include('footer')
@endsection
