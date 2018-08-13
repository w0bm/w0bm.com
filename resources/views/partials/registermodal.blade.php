<div class="modal fade" id="registermodal" tabindex="-1" role="dialog" aria-labelledby="Login">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="filterModalTitle">Register</h4>
            </div>
            
            <div class="modal-body">
	   		        <div class="register">
        <div class="col-md-8">
        <form class="form-horizontal" method="post" action="{{action('UserController@store')}}">
            {!! csrf_field() !!}
            <div class="form-group">
                <div class="">
                    {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Username']) !!}
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
      <div class="form-group terms">
    <div style="">
    <p><input type="checkbox" required name="terms"> I am at least 18 years or older and I have read and understand the <a href="/rules">Rules</a></p>
    </div>
    <div class="">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </div>
        </form>
    </div>
    </div>
            </div>

            <div class="modal-footer">
              <p>Back to <a href="#" data-toggle="modal" data-target="#loginmodal" data-dismiss="modal">Login?</a></p>
            </div>
    </div>
</div>
</div>
