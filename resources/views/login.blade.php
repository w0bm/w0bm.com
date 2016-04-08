@extends('layout')
@section('content')
    <div class="page-header">
        <h1>Login</h1>
    </div>


    <div class="container">
	<form action="{{action('UserController@login')}}" method="post" class="form-signin">
                    {!! csrf_field() !!}
                        <input type="text" name="identifier" placeholder="" class="form-control">
                        <input type="password" name="password" placeholder="" class="form-control">
                        <input type="checkbox" name="remember">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <a href="{{url('register')}}" class="btn btn-success">Register</a>
    </div> 
</form>
@endsection
