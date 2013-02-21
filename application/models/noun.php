<?php

class Noun extends Basemodel 
{	
	public static $rules = array(
		'word' => 'required|alpha_dash'
	);

	public function verbs() {
		return $this->has_many_and_belongs_to('Verb');
	}
}