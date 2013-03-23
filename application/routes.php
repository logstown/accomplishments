<?php

// user Resource
Route::get('/', array('as'=>'home', 'uses'=>'home@things'));
Route::get('about', function()
{
	return View::make('static.about')->with('title', 'Accomplishments - About');
});
Route::get('graph', array('as' => 'graph', 'uses' => 'nodes@graph'));
Route::get('register', array('as' => 'register', 'uses' => 'users@new'));
Route::get('login', array('as'=>'login', 'uses'=>'users@login'));
Route::get('logout', array('as'=>'logout', 'uses'=>'users@logout'));

Route::post('register', array('before'=>'csrf', 'uses'=>'users@create'));
Route::post('graph', array('before'=>'csrf', 'uses'=>'nodes@add'));
Route::post('login', array('before'=>'csrf', 'uses'=>'users@login'));
Route::post('add', array('before'=>'csrf', 'uses'=>'nodes@add'));




Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});


Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});