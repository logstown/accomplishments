@layout('layouts.default')

@section('content')
	<div class="container">

	@if($errors->has())
		<p>The following errors have occurred:</p>

		<ul id="form-errors">
			{{ $errors->first('username', '<li>:message</li>') }}
			{{ $errors->first('password', '<li>:message</li>') }}
			{{ $errors->first('password_confirmation', '<li>:message</li>') }}
		</ul>
	@endif

	{{ Form::open('register', 'POST', array('class' => 'form-horizontal')) }}

	<div class="control-group">
	<div class="controls">
	<legend>Register</legend>
	</div>
	</div>

	{{ Form::token() }}
		<div class="control-group">
		{{ Form::label('username', 'Username', array('class' => 'control-label')) }}
		<div class="controls">
		{{ Form::text('username', Input::old('username')) }}
		</div>
		</div>

		<div class="control-group">
		{{ Form::label('password', 'Password', array('class' => 'control-label')) }}
		<div class="controls">
		{{ Form::password('password') }}
		</div>
		</div>
	
		<div class="control-group">
		{{ Form::label('password_confirmation', 'Confirm Password', array('class' => 'control-label')) }}
		<div class="controls">
		{{ Form::password('password_confirmation') }}
		</div>
		</div>
	
	<div class="control-group">
	<div class="controls">
	{{ Form::button('Register', array('class' => 'btn btn-primary')) }}
	</div>
	</div>

	{{ Form::close() }}
	</div>
@endsection