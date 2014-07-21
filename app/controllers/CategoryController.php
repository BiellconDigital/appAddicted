<?php
use Facebook\FacebookSession;
use Facebook\GraphNodes\GraphUser;
use Facebook\Helpers\FacebookJavaScriptLoginHelper;
use Facebook\Helpers\FacebookCanvasLoginHelper;
use Facebook\Exceptions\FacebookRequestException;
use Facebook\FacebookRequest;

class CategoryController extends BaseController {

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
            
            $categories = Category::all();
            
            return View::make('categories')
                    ->with('categories', $categories);
	}
        
        public function amigos($idCate) {
            FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
            //$pageHelper = new FacebookPageTabHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
            //$helper = new FacebookRedirectLoginHelper( Config::get('app')['url'] . '/login/fb/callback' );
	    
            $pageHelper = new FacebookJavaScriptLoginHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
            $session = $pageHelper->getSession();
            /* make the API call */
            $user_friends = (new FacebookRequest(
              $session, 'GET', '/me/friends', array("fields" => "id,gender,name,picture"), 'v1.0'
            ))->execute()->getGraphObject()->asArray();
            $friends = $user_friends['data'];
            foreach ($friends as $key => $friend) {
                if ($friend->gender == "female") {
                    array_forget($friends, $key);
                }
            }

            //print_r($user_friends);exit();

            return View::make('amigos')
                    ->with('user_friends', $friends)
                    ->with('idCate', $idCate);
        }

}
