<div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="Login">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="filterModalTitle">Login</h4>
            </div>
            <div class="modal-body">

	<form action="{{action('UserController@login')}}" method="post" class="navbar-form navbar-right">
	{!! csrf_field() !!}
		<div class="loginmodaldiv">
                        <input type="text" name="identifier" placeholder="Username" class="form-control usernamelogin"><br>
                        <input type="password" name="password" placeholder="Password" class="form-control passwordlogin"><br>
                        <button type="submit" class="btn btn-primary">Login</button> <input id="rememberme" type="checkbox" name="remember"> <span id="rember">Remember me?</span>
		</div>
	</form>
	   </div>
	    	<div class="modal-footer">
	    		<p>No w0bm account yet? <a href="#" data-toggle="modal" data-target="#registermodal" data-dismiss="modal">Register now!</a></p>
        	</div>
        </div>
    </div>
</div>
