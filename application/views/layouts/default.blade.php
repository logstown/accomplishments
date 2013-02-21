<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>{{ $title }}</title>
	<meta name="viewport" content="width=device-width">
	{{ HTML::style('css/bootstrap.css') }}
	{{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js') }}
	<style type="text/css">
	body {

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
			</ul>
			</div><!-- end searchbar -->
		</div>
		</div><!-- end nav -->

		<div id="content">
			<p id="message">
			@if(Session::has('message'))
				{{ Session::get('message') }}
			@endif
			</p>

			@yield('content')
		</div><!-- end content -->

		<div id="footer">
			&copy; Accomplishments {{ date('Y') }}
		</div><!-- end footer -->

	</div><!-- end container -->

</body>
</html>