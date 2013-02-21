@layout('layouts.default')

@section('content')
	<h1>Login</h1>

	{{ Form::open('login', 'POST', array('class' => 'form-horizontal')) }}

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
	<div class="controls">
	{{ Form::submit('Login') }}</p>
	</div>
	</div>
	{{ Form::close() }}
@endsection