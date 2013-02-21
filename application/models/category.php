<?php

class Category extends Basemodel 
{	
	public static $rules = array(
		'word' => 'required|alpha_dash'
	);

	public function user() {
		return $this->belongs_to('User');
	}

	public function verbs() {
		return $this->has_many('Verb');
	}

	public function get_noun($n_word) {
		$verbs = $this->verbs;

		foreach ($verbs as $verb) {
			$noun = $verb->nouns()->where_word($n_word)->first();
			if ($noun) {
				return $noun;
			}
		}

		return $noun;
	}

	public static function your_categories() {
		return static::where('user_id','=',Auth::user()->id)->paginate(3);
	}
}