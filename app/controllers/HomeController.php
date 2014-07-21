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
            try {
                $uid = Session::get('uid');
                $profile = Profile::whereUid($uid)->first();
                if (empty($profile)) {
                    return Redirect::to('/noauth')->with('message', 'No está registrado para participar.');
                }            
                $user = $profile->user;

                if ($user->inscrito) {
                    Auth::login($user);
                    return Redirect::to('/categorias');
                            //->with('message', 'Logged in with Facebook');
                } else {
    //                return View::make('inscripcion');
                    return Redirect::route('inscripcion', array('id' => $user->id));
                }

                return View::make('home');
            } catch (Exception $e) {
                return Redirect::to('/error')->with('message', 'Ha ocurrido un error.');
            }
	}

        public function invite() {
                return View::make('invite');
        }
}
