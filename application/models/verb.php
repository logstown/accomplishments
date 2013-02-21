<?php

class Verb extends Basemodel 
{	
	public static $rules = array(
		'word' => 'required|alpha_dash'
	);

	public function category() {
		return $this->belongs_to('Category');
	}

	public function nouns() {
		return $this->has_many_and_belongs_to('Noun');
	}
}