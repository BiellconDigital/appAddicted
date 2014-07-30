<?php
use Facebook\FacebookSession;
use Facebook\Helpers\FacebookJavaScriptLoginHelper;
use Facebook\Helpers\FacebookCanvasLoginHelper;
use Facebook\Exceptions\FacebookRequestException;
use Facebook\FacebookRequest;
use Facebook\Exceptions\FacebookAuthorizationException;

class RankingController extends BaseController {

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

	public function index()
	{
            
            try {
                FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
                $token_url =    "https://graph.facebook.com/oauth/access_token?" .
                "client_id=" . Config::get('facebook')['appId'] .
                "&client_secret=" . Config::get('facebook')['secret'] .
                "&grant_type=client_credentials";
                $app_token = file_get_contents($token_url);
                $idtoken = explode("=", $app_token)[1];
//                $pageHelper = new FacebookJavaScriptLoginHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
//                $session = $pageHelper->getSession();
                $session = new FacebookSession($idtoken);

                $participants = DB::table('user')
                    ->join('profile', 'user.id', '=', 'profile.user_id')
                    ->where('user.inscrito', true)
                    ->orderBy('votes', 'desc')
                    ->get();
                
                foreach ($participants as $key => $participant) {
                    //Obtener foto de la participante
                    $request = new FacebookRequest(
                        $session,
                        'GET',
                        "/" . $participant->uid . "/picture",
                        array (
                            'width' => 100,
                            'height' => 95,
                            'redirect' => false
                        )
                        , 'v1.0' 
                    );
                    $response = $request->execute();
                    $photoParticipant = $response->getGraphObject()->asArray();
                    $participants[$key]->photo = $photoParticipant->url;
                }

                return View::make('ranking')
                        ->with('participants', $participants);
            
            } catch (FacebookAuthorizationException $e) {
                return Redirect::to('/sesionexpirada')
                        ->with('message', 'Su sesión ha expirado. Por favor haga click en reiniciar. ' . $e->getMessage());
            }
	}
        
        public function amigos($idCate) {
            try {
                FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
                //$pageHelper = new FacebookPageTabHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
                //$helper = new FacebookRedirectLoginHelper( Config::get('app')['url'] . '/login/fb/callback' );

                $pageHelper = new FacebookJavaScriptLoginHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
                $session = $pageHelper->getSession();

                $user_friends = (new FacebookRequest(
                    $session, 'GET', '/me/friends', array("fields" => "id,gender,name,picture"), 'v1.0'
                ))->execute()->getGraphObject()->asArray();
                $friends = $user_friends['data'];
                $search = Input::get('search');
                
                if (Request::isMethod('post') and $search != "") {
                    //select uid, name, sex from user where uid in (SELECT uid2 FROM friend WHERE uid1 = me())and (strpos(lower(name),'Jack')>=0 OR strpos(name,'Jack')>=0)
                    foreach ($friends as $key => $friend) {
                        if ($friend->gender == "female") {
                            array_forget($friends, $key);
                            continue;
                        }
                        if (substr_count($friend->name, $search) <= 0) {
                            array_forget($friends, $key);
                        }
                    }

                } else {
                    foreach ($friends as $key => $friend) {
                        if ($friend->gender == "female") {
                            array_forget($friends, $key);
                        }
                    }
                }

                //print_r($user_friends);exit();

                return View::make('amigos')
                        ->with('user_friends', $friends)
                        ->with('idCate', $idCate);
            } catch (FacebookAuthorizationException $e) {
                return Redirect::to('/sesionexpirada')->with('message', 'Su sesión ha expirado. Por favor haga click en reiniciar.');
            }
        }

}
