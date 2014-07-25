<?php
use Facebook\FacebookSession;
use Facebook\Helpers\FacebookJavaScriptLoginHelper;
use Facebook\FacebookRequest;

class VictimController extends BaseController {

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
            
	}
        
        public function savevictims($idCate) {
            $idVictims = Input::get('ids');
            FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
            $pageHelper = new FacebookJavaScriptLoginHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
            $session = $pageHelper->getSession();
            
            $category = Category::find($idCate);
            $user = Auth::user();
            
            foreach ($idVictims as $idVictim) {
                $victim = Victim::whereUid($idVictim)->first();
                if (empty($victim)) {
                    $request = new FacebookRequest( $session, 'GET', '/' . $idVictim, null, 'v1.0' );
                    $response = $request->execute();
                    $meVictim = $response->getGraphObject()->asArray();
                    
                    $victim = new Victim();
                    $victim->uid = $idVictim;
                    $victim->name = $meVictim['name'];
                    $victim->category()->associate($category);
                    //$victim = $user->victims()->save($victim);
                    $victim->user()->associate($user);
                    //$victim = $category->victims()->save($victim);
                    $victim->voted = false;
                    $victim->save();
                }
            }
                return Redirect::to('/categorias')->with('message', 'Se envió las invitaciones a sus víctimas.');
            
//            print_r(Input::all());
//                        exit();
                        
                        
            /*
            FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
	    
            $pageHelper = new FacebookJavaScriptLoginHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
            $session = $pageHelper->getSession();
            $user_friends = (new FacebookRequest(
              $session, 'GET', '/me/taggable_friends'
            ))->execute()->getGraphObject()->asArray();

            //print_r($user_friends);exit();

            return View::make('amigos')
                    ->with('user_friends', $user_friends['data']);
            */
            
        }

        public function votar() {
                return View::make('votar');
        }
}
