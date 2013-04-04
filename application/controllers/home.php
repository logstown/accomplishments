<?php

class Home_Controller extends Base_Controller {

	public $restful = true;

	public function __construct() {
		$this->filter('before', 'auth')->only(array('action_things'));
	}

	// Gets most recent sentences and the most frequent Categories, Verbs, and Nouns
	public function get_stats()
	{
		return View::make('home.index')
			->with('title', 'Accomplishments - Home')
			->with('sentences', $this->sentences())
			->with('categories', $this->chart('categories'))
			->with('verbs', $this->chart('verbs'))
			->with('nouns', $this->chart('nouns'));
	}

	// Static about page
	public function get_about()
	{
		return View::make('static.about')->with('title', 'Accomplishments - About');
	}

	// In: N/A
	// Out: An array of the top 5 user-created sentences and the time created.
	private function sentences()
	{
		// 5 Most recent sentences taken from most recent connection from verb to noun
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
		}

		return $sentences;
	}

	// In: type of word in sentence
	// Out: a table of the top 3 most frequently used words and their counts.
	private function chart($type)
	{
		// Get most frequent words
		$top_words = DB::query('select word, count(*) as word_count 
								from ' . $type . '
								group by word 
								order by word_count desc 
								limit 3');

		// Format for table output
		$chart = array(array(ucfirst($type), 'Count'));

		foreach ($top_words as $top_word) 
			array_push($chart, array($top_word->word, (int)$top_word->word_count));

		return $chart;
	}

}