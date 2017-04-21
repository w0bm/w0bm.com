@extends('profilelayout')
@section('content')
<?php
use \App\Models\Donation;
?>
<div class="page-header">
        <h4>Support us</h4>
    </div>
<div class="row">
</div>

<div class="col-md-6">
	<h5>Progress</h5>
	<p>You enjoy w0bm? Donate a small amount of money so we can pay the server and keep this website running.</p>
	<div class="progress" style="width: 100%">
        @if(Donation::getFunds() >= 0)
  		    <div class="progress-bar-success" role="progressbar" aria-valuenow="{{ Donation::getFunds() }}" aria-valuemin="0" aria-valuemax="{{ Donation::$needed }}" style="text-align:center; color:white; width: {{ max(0, min(100, abs(Donation::getPercentage()))) }}%;">
        @else
            <div class="progress-bar-danger" role="progressbar" aria-valuenow="{{ Donation::getFunds() }}" aria-valuemin="0" aria-valuemax="{{ Donation::$needed }}" style="text-align:center; color:white; width: {{ max(0, min(100, abs(Donation::getPercentage()))) }}%;">
        @endif
		{{ number_format(Donation::getFunds(), 2) }}&nbsp;€
		</div>
	</div>
	<p>Currently we accept PayPal and Bitcoin</p>
	<i class="fa fa-btc" style="color: #1FB2B0;" aria-hidden="true"></i> <span style="font-family:monospace;color:#1FB2B0;">1PXqtRtZLYwRFKKks7tipVXeauGSpy3u4z</span> <span><b>[ PREFERRED ]</b></span>
	<br />
	<i class="fa fa-paypal" style="color: #1FB2B0;"></i> <span style="font-family:monospace;coloR:#1FB2B0;">paypal@w0bm.com</span>
	<br />
	<p>We also opened up a Patreon account if you want to support w0bm every month <a href="https://www.patreon.com/w0bm">click here.</a></p>
	<p>There is a small reward for donations, it's not much but all we can give back to you as a thanks.</p>
	<p>Donors will receive a icon of choice with every donation over 5€ behind their name.</p>
  </div>

  <h5>The qties</h5>
  <div class="col-md-6 donationlist" style="">
  <table class="table table-condensed" style="border-collapse: collapse;">
        <thead>
        <tr>
            <th>Name</th>
            <th>Amount</th>
            <th>Payment method</th>
            <th>Date</th>
	</tr>
	</thead>
        <tbody>
            @foreach($donations as $d)
                <tr class="@if($d->amount >= 0) success @else danger @endif">
                    <td>@if(is_null($d->name)) Anonym @elseif(is_null($d->url)){{ $d->name }} @else <a href="{{ $d->url }}">{{ $d->name }}</a> @endif </td>
                    <td>{{ number_format($d->amount, 2) }}€</td>
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
