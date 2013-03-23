@layout('layouts.default')

@section('content')
	<div class="container">

		{{ Form::open('login', 'POST', array('class' => 'form-horizontal')) }}
			<fieldset>
				<div class="control-group">
					<div class="controls">
						<legend>Login</legend>
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
					<div class="controls">
						{{ Form::button('Login', array('class' => 'btn btn-success')) }}</p>
					</div>
				</div>
			</fieldset>
		{{ Form::close() }}
	</div>
@endsection