@extends('profilelayout')
@section('content')
<h5>What do we log?</h5>
<p>We use our own self-hosted Piwik instance to get some info on what's going on, down below you have the option to deactivate tracking if you don't want to be tracked.</p>
<iframe style="border: 0; height: 200px; width: 600px;" src="https://observation.stasi.club/index.php?module=CoreAdminHome&action=optOut&language=en"></iframe>
@include('footer')
@endsection
