<?php
use Facebook\FacebookSession;
use Facebook\Helpers\FacebookJavaScriptLoginHelper;
use Facebook\Helpers\FacebookCanvasLoginHelper;
use Facebook\Exceptions\FacebookRequestException;
use Facebook\FacebookRequest;
use Facebook\Exceptions\FacebookAuthorizationException;

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
            try {
                $categories = Category::all();

                return View::make('categories')
                        ->with('categories', $categories);
            } catch (\Exception $e) {
                return Redirect::to('/error')->with('message', 'Ha ocurrido un error.');
            }
	}
        
        public function amigos($idCate) {
            try {
                $filtrado = false;
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
                
                $first = DB::table('victim')->where('user_id', Auth::user()->id)->where('voted', true);
                $victims = DB::table('victim')->where('user_id', Auth::user()->id)->where('voted', false)
                                ->where('updated_at', ">", \Carbon\Carbon::now()->subDays(1)->toDateString())
                                ->union($first)->get();

                
                if (Request::isMethod('post') and $search != "") {
                    //select uid, name, sex from user where uid in (SELECT uid2 FROM friend WHERE uid1 = me())and (strpos(lower(name),'Jack')>=0 OR strpos(name,'Jack')>=0)
                    foreach ($friends as $key => $friend) {
                        if ($friend->gender == "female") {
                            array_forget($friends, $key);
                            continue;
                        }
			if(stristr($friend->name, $search) === FALSE) {
//                        if (substr_count($friend->name, $search) <= 0) {
                            array_forget($friends, $key);
                            $filtrado = true;
                            continue;
                        }
                        
                        foreach ($victims as $victim) {
                            if ($victim->uid == $friend->id) {
                                array_forget($friends, $key);
                                continue;
                            }
                        }
                    }

                } else {
                    foreach ($friends as $key => $friend) {
                        if ($friend->gender == "female") {
                            array_forget($friends, $key);
                            continue;
                        }
                        
                        foreach ($victims as $victim) {
                            if ($victim->uid == $friend->id) {
                                array_forget($friends, $key);
                                continue;
                            }
                        }
                    }
                }

                //print_r($user_friends);exit();

                return View::make('amigos')
                        ->with('user_friends', $friends)
                        ->with('idCate', $idCate)->with('filtrado', $filtrado);
            } catch (FacebookAuthorizationException $e) {
                return Redirect::to('/sesionexpirada')->with('message', 'Su sesión ha expirado. Por favor haga click en reiniciar.');
            } catch (\Exception $e) {
                return Redirect::to('/error')->with('message', 'Ha ocurrido un error.');
            }
        }

}
