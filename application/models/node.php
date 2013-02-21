<?php

class Node extends Basemodel 
{
	protected static $rules = array(
		'word' => 'required|alpha_dash'
	);

	public static function nodes() {
	//	return Category::all() + Verb::all() + Noun::all();
		return array('word' => 'hmmm');
	}

	public static function add_nodes($c_word, $v_word, $n_word)
	{
		$category = new Category(array('word' => $c_word));
		$category = Auth::user()->categories()->insert($category);
		
		$verb = new Verb(array('word' => $v_word));
		$verb = $category->verbs()->insert($verb);

		$noun = new Noun(array('word' => $n_word));
		$verb->nouns()->insert($noun);

		return 'inserted';
	}
}