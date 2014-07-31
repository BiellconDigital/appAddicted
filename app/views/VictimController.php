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
            
            if(Session::has('friend')) {
                FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
                
                $token_url =    "https://graph.facebook.com/oauth/access_token?" .
                "client_id=" . Config::get('facebook')['appId'] .
                "&client_secret=" . Config::get('facebook')['secret'] .
                "&grant_type=client_credentials";
                $app_token = file_get_contents($token_url);
                $idtoken = explode("=", $app_token)[1];
                $pageHelper = new FacebookJavaScriptLoginHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
                //$session = new FacebookSession($idtoken);
                $session = $pageHelper->getSession();
                
                $from_id = Session::get('from_id');
                $to_id = Session::get('uid');
                
                //Obtener datos de la amiga
                $data = DB::table('user')
                    ->join('profile', 'user.id', '=', 'profile.user_id')
                    ->where('profile.uid', $from_id)
                    ->get();
                $userProfile = $data[0];
                
                //Actualizar votacion de la victima
                $victim = Victim::where('user_id', $userProfile->user_id)
                    ->where('uid', $to_id)->first();
                print $userProfile->user_id . ' -- ';
                print $to_id. ' -- ';
                var_dump($victim);
                
                $votedAnt = $victim->voted;
                
                if (!$votedAnt) {
                    //Enviar notificación de victima a amiga
                    $request = new FacebookRequest(
                        $session,
                        'POST',
                        "/$from_id/notifications",
                        array (
                            'href' => 'victimas/redirigir-video/' . $to_id,
                            'template' => " @[" . $to_id . "] ha aceptado tu invitación para participar",//@[$to_id] @[596824621]
                        )
                        , 'v1.0' 
                    );
                    $response = $request->execute();
                    $graphObject = $response->getGraphObject();
                    $victim->voted = true;
                    $victim->save();
                    
                    DB::table('user')->whereId($userProfile->id)
                            ->increment('votes');//->
                }
                
                //Obtener total de votos de la amiga
                $totalVictimas = Victim::where('voted', true)
                    ->where('user_id', $userProfile->user_id)->count();
                
                //Nombre completo de la amiga
//                $nombreAmiga = $userProfile->form_nombre . ' ' . $userProfile->form_ape_paterno . ' ' . $userProfile->form_ape_materno;
                $nombreAmiga = $userProfile->form_nombre . ' ' . $userProfile->form_apellido;


                return View::make('votarresultado')->with('nombreAmiga', $nombreAmiga)
                    ->with('totalVictimas', $totalVictimas);
            } else {
                return Redirect::to('/error')->with('message', 'Es un acceso incorrecto a la aplicación.');
            }
        }
        
        public function redirigirVideo($idvictim) {
            if( $_REQUEST['fb_source'] == "notification" ) {
                try {
                    Session::put('id-victim-video', $idvictim);
                    return View::make('redirigirvideo');
                    
                } catch (\Exception $e) {
                    return Redirect::to('/error')->with('message', 'Ha ocurrido un error o es un acceso incorrecto a la aplicación.');
                }

            } else {
                var_dump($_REQUEST);
                return Redirect::to('/error')->with('message', 'Es un acceso incorrecto a la aplicación.');
            }
        }
        
}
