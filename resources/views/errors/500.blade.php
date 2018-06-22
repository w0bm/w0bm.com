@extends('profilelayout')
@section('content')
<style>
.sf-reset .block {
    background-color: #000000;
    padding: 10px 28px;
    margin-bottom: 20px;
    -webkit-border-bottom-right-radius: 0;
    -webkit-border-bottom-left-radius: 0;
    -moz-border-radius-bottomright: 0;
    -moz-border-radius-bottomleft: 0;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    border-bottom: 1px solid #1faeac;
    border-right: 1px solid #1faeac;
    border-left: 1px solid #1faeac;
    border-top: 1px solid #1faeac;
    word-wrap: break-word;
    color: green;
}
</style>

	<h5>Oh shit! Something went wrong!</h5>
        <div id="sf-resetcontent" class="sf-reset box">
		<h6>Please don't send this fucking text to an admin, we have other problems.</h6>
            <?php
                $iv = openssl_random_pseudo_bytes(16);
            ?>
            @if(!env('APP_DEBUG'))
            <div class="block">
                {{bin2hex($iv)}}<br>
                {{openssl_encrypt($exception, 'aes128', env('APP_KEY'), 0, $iv)}}
            </div>
            @else
            <div class="block">
                <pre>{{$exception}}</pre>
            </div>
            @endif

        </div>
@include('footer')
@endsection
