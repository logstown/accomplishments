<?php

class Home_Controller extends Base_Controller {

	/*
	|--------------------------------------------------------------------------
	| The Default Controller
	|--------------------------------------------------------------------------
	|
	| Instead of using RESTful routes and anonymous functions, you might wish
	| to use controllers to organize your application API. You'll love them.
	|
	| This controller responds to URIs beginning with "home", and it also
	| serves as the default controller for the application, meaning it
	| handles requests to the root of the application.
	|
	| You can respond to GET requests to "/home/profile" like so:
	|
	|		public function action_profile()
	|		{
	|			return "This is your profile!";
	|		}
	|
	| Any extra segments are passed to the method as parameters:
	|
	|		public function action_profile($id)
	|		{
	|			return "This is the profile for user {$id}.";
	|		}
	|
	*/

	public function action_things()
	{
		$connections = DB::table('noun_verb')->order_by('created_at', 'DESC')->take(5)->get();

		$sentences = array();
		foreach ($connections as $connection) {
			$noun = Noun::find($connection->noun_id);
			$verb = Verb::find($connection->verb_id);
			$category = $verb->category;
			$user = $category->user;

			$sentences[$connection->id] = $noun->word . ' is a ' . $category->word . ' that ' . $user->username . ' has ' . $verb->word . '.';
		}

		$categories = DB::query('select word, count(*) as word_count 
								from categories 
								group by word 
								order by word_count desc 
								limit 3');
		$verbs = DB::query('select word, count(*) as word_count 
							from verbs 
							group by word 
							order by word_count desc 
							limit 3');
		$nouns = DB::query('select word, count(*) as word_count 
							from nouns 
							group by word 
							order by word_count desc 
							limit 3');

		return View::make('home.index')
			->with('title', 'Accomplishments - Home')
			->with('sentences', $sentences)
			->with('categories', $categories)
			->with('verbs', $verbs)
			->with('nouns', $nouns);
	}

}