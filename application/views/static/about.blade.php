@layout('layouts.default')

@section('content')
<h1 class="form-center">About</h1>

<div class="container">
	<br>
	<p> 'Accomplishments allows you to graph your various accomplishments in an intuitive and expressive way, using the {{ HTML::link('http://arborjs.org', 'arbor.js')}} visulization library.</p>
	<br>
	@if(Auth::check())
		<p>{{ HTML::link_to_route('graph', "Create your graph now") }}</p>
	@else
		<p>{{ HTML::link_to_route('login', "Log in") }} or {{ HTML::link_to_route('register', "Register") }} to start graphing!</p>
	@endif
	<br>
	<br>
	<p> This is a ongoing project by myself, {{ HTML::link('http://loganjoecks.com', 'Logan Joecks')}}. It is meant to showcase my skills with PHP using the {{ HTML::link('http://laravel.com', 'Lavavel Framework')}}.</p>

</div>
@endsection
