<?php

class Users_Controller extends Base_Controller {

	public $restful = true; 

    // Register View
	public function get_new()
    {
        return View::make('users.new')
            ->with('title', 'Register');
    }    

    // Creates new user and logs them in to 'Home'view or redirects back if errors
	public function post_create()
    {
        $validation = User::validate(Input::all());

        if ($validation->passes()) {
            User::create(array(
                'username'=>Input::get('username'),
                'password'=>Hash::make(Input::get('password'))
            ));

            $user = User::where_username(Input::get('username'))->first();
            Auth::login($user->id);

            return Redirect::to_route('home')
                ->with('message', 'Thanks for registering '. $user->username . '! Your are now logged in.');
        } else {
            return Redirect::to_route('register')->with_errors($validation)->with_input();
        }
    }    

    // Log in View
	public function get_login() {
        return View::make('users.login')
            ->with('title', 'Accomplishments - Login');
    }

    // Logs user in and redirects to their grapsh
    public function post_login() {
        $user = array(
            'username'=>Input::get('username'),
            'password'=>Input::get('password')
        );

        if (Auth::attempt($user)) {
            return Redirect::to_route('graph')->with('message', 'You are logged in!');
        } else {
            return Redirect::to_route('login')
                ->with('message', 'Your username/password combination was incorrect')
                ->with_input();
        }
    }

    // Logs user out and redirects to Log in View
    public function get_logout() {
        if (Auth::check()) {
            Auth::logout();
            return Redirect::to_route('login')->with('message', 'Your are now logged out!');
        } else {
            return Redirect::to_route('home');
        }
    }
}