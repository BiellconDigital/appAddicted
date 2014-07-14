<?php
use Facebook\FacebookSession;
use Facebook\Helpers\FacebookRedirectLoginHelper;
use Facebook\Helpers\FacebookPageTabHelper;
use Facebook\Exceptions\FacebookRequestException;
use Facebook\FacebookRequest;

class LoginController extends BaseController {

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

	public function fbCallback()
	{
            $code = Input::get('code');
            if (strlen($code) == 0)  return Redirect::to('/')->with('message', 'Se ha producido un error al comunicarse con Facebook.');

            FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
            //$pageHelper = new FacebookPageTabHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
            $helper = new FacebookRedirectLoginHelper( Config::get('app')['url'] . '/login/fb/callback' );

            $session = $helper->getSessionFromRedirect();
         
            $uid = $session->getUserId();
            //$facebook = new Facebook(Config::get('facebook'));
            //$uid = $facebook->getUser();

            if ($uid == 0) return Redirect::to('/')->with('message', 'Hubo un error');

            $request = new FacebookRequest( $session, 'GET', '/me' );
            $response = $request->execute();
            // Responce
            $me = $response->getGraphObject(GraphUser::className);
            //getBirthday;
            //$me = $facebook->api('/me');

            $profile = Profile::whereUid($uid)->first();
            if (empty($profile)) {
                $user = new User;
                $user->name = $me->getFirstName() . ' '. $me->getLastName();
                $user->email = $me->getEmail();
                $user->photo = 'https://graph.facebook.com/'. $me->getUsername() .'/picture?type=large';

                $user->save();

                $profile = new Profile();
                $profile->uid = $uid;
                $profile->username = $me->getUsername();
                $profile = $user->profiles()->save($profile);
            }

            $profile->access_token = $session->getAccessToken();
            $profile->save();
            $user = $profile->user;

            Auth::login($user);

            //return Redirect::to('/')->with('message', 'Logged in with Facebook');
            return View::make('inscripcion');
	}

}
