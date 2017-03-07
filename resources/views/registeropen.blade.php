@extends('layout')
@section('content')
    <div class="page-header">
        <h5>Register your w0bm.com Account</h5>
    </div>
    <div class="register">
        <form class="form-horizontal" method="post" action="{{action('UserController@store')}}">
            {!! csrf_field() !!}
            <div class="form-group">
                <div class="">
                    {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Username']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="">
                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="">
                    {!! Form::email('email_confirmation', null, ['class' => 'form-control', 'placeholder' => 'Email Confirmation']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="">
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="">
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Password Confirmation']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="">
                    {!! Recaptcha::render() !!}
                </div>
	    </div>
            <div class="form-group">
                <div class="">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </div>
        </form>
    </div>
    <div class="form-group" style="
		text-align: center;
		background: rgba(0, 0, 0, 0.75);
		margin-left: 5px;
                margin-right: 5px;
    				  ">
	<p>By clicking on "Register" you accept our <a href="/rules">Rules</a></p>
	<p>Note: we do NOT reset passwords for now, make sure to save your password correctly</p>
    </div>
    @endsection

