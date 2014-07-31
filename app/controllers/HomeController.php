<?php
use Facebook\Exceptions\FacebookAuthorizationException;

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
                
                if(Session::has('id-victim-video')) {
                    $idvictim = Session::get('id-victim-video');
                    Session::forget('id-victim-video');
                    if (!Auth::check()) {
                        Auth::login($profile->user);
                    }
                    //Auth::user()->id;
                    return Redirect::route('video', array('uid' => $idvictim, 'userid' => $profile->user->id));
                }
                
                if (!empty($profile)) {
                    $user = $profile->user;

                    if ($user->inscrito) {
                        Auth::login($user);
                        return Redirect::route('categorias');
                                //->with('message', 'Logged in with Facebook');
                    } else {
                        return Redirect::route('inscripcion', array('id' => $user->id));
                    }
                }
                
                $victim = Victim::whereUid($uid)->first();
                if (!empty($victim)) {
//                    $data = DB::table('user')
//                        ->join('profile', 'user.id', '=', 'profile.user_id')
//                        ->where('user.id', $victim->user_id)
//                        ->get();
//                    $userProfile = $data[0];
//                    
//                    Session::put('from_id', $userProfile->uid);
                    return Redirect::route('victim.votar');
                }
                
//                if (empty($profile)) {
                return Redirect::to('/noauth')->with('message', 'No está registrado para participar.');
//                }            
//                return View::make('home');
            } catch (\Exception $e) {
                return Redirect::to('/error')->with('message', 'Ha ocurrido un error.');
            }
	}

        public function invite() {
            if( isset($_REQUEST['request_ids']) ) {
                try {
                    $_SESSION['request_ids'] = $_REQUEST['request_ids'];
                    Session::put('friend', 'yes');
                    return View::make('invite');
//exit();
                } catch (\Exception $e) {
                    return Redirect::to('/error')->with('message', 'Ha ocurrido un error o es un acceso incorrecto a la aplicación. ' .$e->getMessage());
                }

            } else {
                return Redirect::to('/error')->with('message', 'Es un acceso inválido a la aplicación.');
            }
        }
}
