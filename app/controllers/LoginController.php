<?php
use Facebook\FacebookSession;
use Facebook\GraphNodes\GraphUser;
use Facebook\Helpers\FacebookJavaScriptLoginHelper;
use Facebook\Helpers\FacebookCanvasLoginHelper;
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
//            $code = Input::get('code');
//            if (strlen($code) == 0)  return Redirect::to('/noauth')->with('message', 'Se ha producido un error al comunicarse con Facebook.');

            FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
            //$pageHelper = new FacebookPageTabHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
            //$helper = new FacebookRedirectLoginHelper( Config::get('app')['url'] . '/login/fb/callback' );
	    
            $pageHelper = new FacebookJavaScriptLoginHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
            $session = $pageHelper->getSession();
//            $session = $helper->getSessionFromRedirect();
//	    $uid = $session->getSignedRequestProperty('user_id');       
            $uid = $pageHelper->getUserId();
            //$facebook = new Facebook(Config::get('facebook'));
            //$uid = $facebook->getUser();

            if ($uid == 0) return Redirect::to('/noauth')->with('message', 'Hubo un error');

            $request = new FacebookRequest( $session, 'GET', '/me' );
            $response = $request->execute();
            // Responce
            $me = $response->getGraphObject()->asArray();//GraphUser::className()
            //getBirthday;
            //$me = $facebook->api('/me');

            $profile = Profile::whereUid($uid)->first();
            if (empty($profile)) {
                $user = new User;
                $user->name = $me['first_name'] . ' '. $me['last_name'];
                $user->email = $me['email'];
                $user->photo = '';
                $user->inscrito = false;
                $user->save();

                $profile = new Profile();
                $profile->uid = $uid;
                $profile->username = $me['email'];
                $profile = $user->profiles()->save($profile);
            }

            $profile->access_token = $session->getAccessToken();
            $profile->save();
            $profile->autorizado = true;
            $user = $profile->user;
            
            if ($user->inscrito) {
                return Redirect::to('/categorias')->with('message', 'Logged in with Facebook');
            } else {
//                return View::make('inscripcion');
		return Redirect::route('inscripcion', array('user' => $user));
            }

//            Auth::login($user);

            //return Redirect::to('/')->with('message', 'Logged in with Facebook');
	}

        public function fbLogin($param) {
            
        }
}
