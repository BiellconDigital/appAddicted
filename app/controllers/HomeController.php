<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function home()
	{
            $uid = Session::get('uid');
            $profile = Profile::whereUid($uid)->first();
            $user = $profile->user;
            
            if ($user->inscrito) {
                Auth::login($user);
                return Redirect::to('/categorias')->with('message', 'Logged in with Facebook');
            } else {
//                return View::make('inscripcion');
		return Redirect::route('inscripcion', array('id' => $user->id));
            }
            
            return View::make('home');
	}

}
