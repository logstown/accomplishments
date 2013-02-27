<?php

class Home_Controller extends Base_Controller {

	public $restful = true;

	public function __construct() {
		$this->filter('before', 'auth')->only(array('action_things'));
	}

	public function get_things()
	{
		$connections = DB::table('noun_verb')->order_by('created_at', 'DESC')->take(5)->get();

		$sentences = array();
		foreach ($connections as $connection) {
			$noun = Noun::find($connection->noun_id);
			$verb = Verb::find($connection->verb_id);
			$category = $verb->category;
			$user = $category->user;

			$sentences[$connection->id] = array(
				'noun' => $noun->word,
				'verb' => $verb->word,
				'category' => $category->word,
				'user' => $user->username,
				'time' => RelativeTime::get($connection->updated_at)
			);

			// $sentences[$connection->id]
			// $sentences[$connection->id]['sentence'] = '<span class="text-info">' . $noun->word . '</span> is a <span class="text-warning">' . $category->word . '</span> that ' . $user->username . ' has <span class="text-error">' . $verb->word . '</span>.';
			// $sentences[$connection->id]['time'] = RelativeTime::get($connection->updated_at);
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
		
		$cat_chart = array(array('Categories', 'Count'));

		foreach ($categories as $category) {
			array_push($cat_chart, array($category->word, (int)$category->word_count));
		}

		$verb_chart = array(array('Verbs', 'Count'));

		foreach ($verbs as $verb) {
			array_push($verb_chart, array($verb->word, (int)$verb->word_count));
		}
		
		$noun_chart = array(array('Nouns', 'Count'));

		foreach ($nouns as $noun) {
			array_push($noun_chart, array($noun->word, (int)$noun->word_count));
		}



		return View::make('home.index')
			->with('title', 'Accomplishments - Home')
			->with('sentences', $sentences)
			->with('categories', $cat_chart)
			->with('verbs', $verb_chart)
			->with('nouns', $noun_chart);
	}

}