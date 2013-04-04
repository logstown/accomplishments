<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>{{ $title }}</title>
	<meta name="viewport" content="width=device-width">

	{{ HTML::style('css/bootstrap.css') }}
	{{ HTML::style('css/style.css') }}
	{{ HTML::script('js/jquery.min.js') }}
	{{ HTML::script('js/main.js') }}
</head>

<body>
	<div id="container">
		<div id="nav-wrapper" class="navbar">
			<div id="nav" class="navbar-inner">
				<div class="container">
					@if($title == 'Accomplishments - Your Graph')
						<ul class="nav pull-left">
							<li class="form-nodes">
								{{ Form::open('', 'POST', array('class' => 'form-inline'))}}

								{{ Form:: token() }}

								<span id="noun-control">
									{{ Form::label('noun','') }}
									<span class="text">
										{{ Form::text('noun','',array('placeholder' => 'noun')) }}
							        </span>
						        </span>

								<span id="cat-control">
									{{ Form::label('category', 'is a') }}
									<span class="text">
										{{ Form::text('category', '', array('placeholder' => 'category')) }}
									</span>
						        </span>

								<span id="verb-control">
									{{ Form::label('verb', 'that I have') }}
									<span class="text">
										{{ Form::text('verb', '', array('placeholder' => 'verbed')) }}
							 		</span>
						        </span>

								{{ Form::submit('add', array('class' => 'btn btn-inverse', 'id' => 'add')) }}
								
								{{ Form::close() }}

				             </li>
			             </ul>
			    	@endif  

					<ul class="nav pull-right">
						<li>{{ HTML::link_to_route('home', 'Home') }}</li>
						<li>{{ HTML::link_to_route('about', 'About') }}</li>
						@if(!Auth::check())
							<li>{{ HTML::link_to_route('register', 'Register') }}</li>
							<li>{{ HTML::link_to_route('login', 'Login') }}</li>
						@else 
							<li>{{ HTML::link_to_route('graph', "Your Graph") }}</li>
							<li>{{ HTML::link_to_route('logout', 'Logout ('.Auth::user()->username.')') }}</li>
						@endif
					</ul>
				</div><!-- end searchbar -->
			</div>
		</div><!-- end nav -->

		<div id="message" class="alert">
			@if(Session::has('message'))
				{{ Session::get('message') }}
			@endif
		</div>

		<div id="content">
			@yield('content')
		</div><!-- end content -->

		<div id="footer">
			&copy; Accomplishments {{ date('Y') }}
		</div><!-- end footer -->
	</div><!-- end container -->
</body>

<script type="text/javascript">
	$('.navbar li').click(function(e) {
		$('.navbar li').removeClass('active');
		var $this = $(this);
		if (!$this.hasClass('active')) {
			$this.addClass('active');
		}
		//e.preventDefault();
	});
</script>

</html>
