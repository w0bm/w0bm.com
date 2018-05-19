@extends('profilelayout')
@section('content')
 <div class="page-header">
         <h3>w0bm.com Community</h3>
 </div>

<div class="box">
<h5>Talk to your local internet nerds</h5>
<p>You can choose between two communities, you can either join our IRC Server, or you can come to our Discord Server, it's up to you!</p>
</div>

<div class="box">
<img src="/irccat.gif" alt="irc cat" style="float: right; width: 25%; height: 25%;">
<h5>IRC</h5>
<h6>irc.n0xy.net +6697 (ssl only) #w0bm</h6>
<p>Don't have a desktop  client? Why not join our Network via webirc? <a href="https://webirc.n0xy.net/?join=%23w0bm" target="about_blank">>>webirc.n0xy.net</a></p>
<p>More information: <a href="https://n0xy.net">n0xy.net</a></p>

<h5>Discord</h5>
<iframe src="https://discordapp.com/widget?id=417311017912238090&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0"></iframe>

<p>Or as normal join link: <a href="https://discord.gg/SuF66vb">https://discord.gg/SuF66vb</a></p>
</div>
@include('footer')
@endsection

