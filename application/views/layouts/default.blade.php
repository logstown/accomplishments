<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>{{ $title }}</title>
	<meta name="viewport" content="width=device-width">
	{{ HTML::style('css/bootstrap.css') }}
	{{ HTML::script('js/jquery.min.js') }}
	<style type="text/css">
	form {
		margin-bottom: 0;
	}
	h2 {
		margin: 0;
	}
	.center {
		text-align: center;
		display: block;
		margin: 0 auto;
	}
	.margins {
		padding-left: 20px;
	}
	
	#buttons {
		text-align: center;
		padding: 50px;
	}

	.butt {
		padding: 40px;
	}

	#footer {
		text-align: center;
	}

	.form-center {
		text-align: center;
	}

	#graph {
		padding: 0;
	}

	html, body {
  width:  100%;
  height: 100%;
  margin: 0px;
}

	</style>

</head>
<body>

	<div id="container">

		<div class="navbar">
		<div id="nav" class="navbar-inner">
		<div class="container">
			<ul class="nav">
				<li>{{ HTML::link_to_route('home', 'Home') }}</li>
				@if(!Auth::check())
					<li>{{ HTML::link_to_route('register', 'Register') }}</li>
					<li>{{ HTML::link_to_route('login', 'Login') }}</li>
				@else 
					<li>{{ HTML::link_to_route('graph', "Your Graph") }}</li>
					<li>{{ HTML::link_to_route('logout', 'Logout ('.Auth::user()->username.')') }}</li>
				@endif
		
				<li>{{ Form::open('search', 'POST', array('class' => 'navbar-search')) }}

				{{ Form::token() }}

				{{ Form::text('keyword', '', array('id'=>'keyword', 'placeholder' => 'Search', 'class' => 'search-query')) }}

				{{ Form::close() }} </li>
				<li>
					
				</li>
			</ul>
			<p id="message" class="navbar-text pull-right">
					@if(Session::has('message'))
						{{ Session::get('message') }}
					@endif
			</p>
			</div><!-- end searchbar -->
		</div>
		</div><!-- end nav -->

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
