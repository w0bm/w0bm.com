@extends('layout')
@section('content')
    <div class="row">
        <form class="form-horizontal" method="post" action="register">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" placeholder="Username">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="email_confirmation" class="col-sm-2 control-label">Email Confirmation</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email_confirmation" placeholder="Email Confirmation">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <label for="password_confirmation" class="col-sm-2 control-label">Password Confirmation</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password_confirmation" placeholder="Password Confirmation">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Register</button>
                </div>
            </div>
        </form>
    </div>
@endsection