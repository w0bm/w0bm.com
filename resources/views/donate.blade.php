@extends('profilelayout')
@section('content')
<?php
use \App\Models\Donation;
?>
<div class="page-header">
        <h4>Support us</h4>
    </div>
<div class="row">
  <div class="col-xs-6">
<h5>About: ~</h5>
<ul>
<li><p>First of all we as your webm provider want to be as transparent as possible to you, our so loved user, feel assfucked :3</p></li>
<li><p>w0bm is a slut, a traffic slut, a money slut and a slut in general, you know what I mean.</p></li>
<li><p>It's getting more difficult to pay the bill with the increasing amount of users, so it's time to reopen donations to collect enough money for the server.</p></li>
<li><p>We know that people love shit, thats apparently one reason why people are browsing w0bm but that's not what I mean in first place, I am talking about something little you will get for your donation beside an alive and well doing w0bm</p></li>
</ul>
<h6>Rewards:</h6>
<p>We are now on Patreon! If you'd like to support us please take a look at <a href="https://www.patreon.com/w0bm">our Patreon page</a></p>
<ul>
<li><p>If you donate 5€ you can choose an icon from <a href="http://fontawesome.io/icons/">fontawesome.io/icons</a></p></li>
<li><p>If you donate 10€ or more you can choose your own personalized icon.</p></li>
<li><p>To claim your icon please join our <a href="/irc">IRC</a></p></li>
  </div>
  <div class="col-xs-6">
</div>

<div class="col-md-6">
	<h5>Overview: ~</h5>
	<p>Like us? Help to keep it alive.</p>
	<div class="progress">
        @if(Donation::getFunds() >= 0)
  		    <div class="progress-bar-success" role="progressbar" aria-valuenow="{{ Donation::getFunds() }}" aria-valuemin="0" aria-valuemax="{{ Donation::$needed }}" style="text-align:center; color:white; width: {{ max(100, min(0, abs(Donation::getPercentage()))) }}%;">
        @else
            <div class="progress-bar-danger" role="progressbar" aria-valuenow="{{ Donation::getFunds() }}" aria-valuemin="0" aria-valuemax="{{ Donation::$needed }}" style="text-align:center; color:white; width: {{ max(100, min(0, abs(Donation::getPercentage()))) }}%;">
        @endif
		{{ Donation::getFunds() ?? '0' }} €
		</div>
	</div>
	<p>Did you know: BTC is super cute :3</p>
	<i class="fa fa-btc" style="color: #1FB2B0;" aria-hidden="true"></i> <span style="font-family:monospace;color:#1FB2B0;">1PXqtRtZLYwRFKKks7tipVXeauGSpy3u4z</span>
	<br />
	<i class="fa fa-paypal" style="color: #1FB2B0;"></i> <span style="font-family:monospace;coloR:#1FB2B0;">paypal@w0bm.com</span>
  </div>

  <div class="col-xs-6">
  <h5>The qties</h5>
  </div>

  <div class="col-xs-6 donationlist" style="">
  <table class="col-xs-6 table table-condensed" style="border-collapse: collapse;">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Amount</th>
            <th>Payment method</th>
            <th>Date</th>
	</tr>
	</thead>
        <tbody>
            @foreach($donations as $d)
                <tr class="@if($d->amount >= 0) success @else danger @endif">
                    <td>{{ $d->id }}.</td>
                    <td>@if(is_null($d->name)) Anonym @elseif(is_null($d->url)){{ $d->name }} @else <a href="{{ $d->url }}">{{ $d->name }}</a> @endif </td>
                    <td>{{ $d->amount }}€</td>
                    <td>@if($d->payment_method == 'BTC') <i class="fa fa-btc"></i> @elseif($d->payment_method == 'PayPal') <i class="fa fa-paypal"></i> @elseif($d->payment_method == 'SEPA') <i class="fa fa-credit-card"></i> @else {{ $d->payment_method }} @endif </td>
                    <td>{{ Carbon\Carbon::parse($d->timestamp)->format('d.m.Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@include('footer')
@endsection
