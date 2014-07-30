<?php
use Facebook\FacebookSession;
use Facebook\Helpers\FacebookJavaScriptLoginHelper;
use Facebook\FacebookRequest;
use Facebook\Exceptions\FacebookAuthorizationException;

class VideoController extends BaseController {

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

	public function index($uid, $userid)
	{
            try {
                FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
                $token_url =    "https://graph.facebook.com/oauth/access_token?" .
                "client_id=" . Config::get('facebook')['appId'] .
                "&client_secret=" . Config::get('facebook')['secret'] .
                "&grant_type=client_credentials";
                $app_token = file_get_contents($token_url);
                $idtoken = explode("=", $app_token)[1];
                $session = new FacebookSession($idtoken);
                
//                $pageHelper = new FacebookJavaScriptLoginHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
//                $session = $pageHelper->getSession();

                $request = new FacebookRequest( $session, 'GET', '/' . $uid, 
                        array("fields" => "id,gender,name,picture.width(110).height(95)")
                        , 'v1.0' );
                $response = $request->execute();
                $meVictim = $response->getGraphObject()->asArray();

                //Obtener total de votos de la amiga
                $totalVictimas = Victim::where('voted', true)
                    ->where('user_id', $userid)->count();

                return View::make('video')->with('meVictim', $meVictim)
                        ->with('totalVictimas', $totalVictimas);
                
            } catch (FacebookAuthorizationException $e) {
                return Redirect::to('/sesionexpirada')->with('message', 'Su sesión ha expirado. Por favor haga click en reiniciar.');
            } catch (\Exception $e) {
                return Redirect::to('/error')->with('message', 'Ha ocurrido un error.');
            }
	}
        
}
