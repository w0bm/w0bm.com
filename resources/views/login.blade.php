@extends('layout')
@section('content')
    <div class="page-header">
        <h5>Legacy Login</h5>
        <p>This login form works without Javascript</p>
    </div>


  <div style="width:20%;" class="">
  <form action="{{action('UserController@login')}}" method="post" class="form-signin">
        {!! csrf_field() !!}
        <input type="text" name="identifier" placeholder="Username" class="form-control">
        <input type="password" name="password" placeholder="Password" class="form-control">
        <input type="checkbox" name="remember"> Remember me<br>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="{{url('register')}}" class="btn btn-success">Register</a>
  </div>
  </form>
@endsection
