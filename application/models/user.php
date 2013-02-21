<?php

class User extends Basemodel 
{
	public static $rules = array(
		'username'=>'required|unique:users|alpha_dash|min:4',
		'password'=>'required|alpha_num|between:4,8|confirmed',
		'password_confirmation'=>'required|alpha_num|between:4,8'
	);

	public function categories() {
		return $this->has_many('Category');
	}

	// public function categories() {
	// 	return $this->has_many('Category');
	// }

	// public function verbs() {
	// 	return $this->has_many('Verb');
	// }

	// public function nouns() {
	// 	return $this->has_many('Noun');
	// }
}