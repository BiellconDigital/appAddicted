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
            try {

                $idVictims = Input::get('ids');
                $id_notification = Input::get('id_notification');

                FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
                $pageHelper = new FacebookJavaScriptLoginHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
                $session = $pageHelper->getSession();

                $category = Category::find($idCate);
                $user = Auth::user();

                foreach ($idVictims as $idVictim) {
                    $victim = Victim::whereUid($idVictim)->where('user_id', $user->id)->first();
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
                    }
                    $victim->id_notification = $id_notification;
                    $victim->save();
                }
                    return Redirect::to('/victimas/registrook')->with('message', 'Se realizó el envío. Pronto sabrás cuales son tus víctimas.');

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
            } catch (\Exception $e) {
                return Redirect::to('/error')->with('message', 'Ha ocurrido un error.');
            }
        }

        public function votar($uid, $notids) {
            try {
                
                    FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);

                    $token_url =    "https://graph.facebook.com/oauth/access_token?" .
                    "client_id=" . Config::get('facebook')['appId'] .
                    "&client_secret=" . Config::get('facebook')['secret'] .
                    "&grant_type=client_credentials";
                    $app_token = file_get_contents($token_url);
                    $idtoken = explode("=", $app_token)[1];
                    //$pageHelper = new FacebookJavaScriptLoginHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
                    $session = new FacebookSession($idtoken);
                    //$session = $pageHelper->getSession();
                    //$uid = $session->getUserId();
                    $request_ids = $notids; // Session::get('app_data');// $_SESSION['request_ids'];  Session::get('request_ids')
                    //print " request_ids: ". $request_ids;
    //                $uid = Session::get('uid');
                    $is_vote = false;
    //                print " Uid del amigo: ". $uid;

                    $requests = explode(',',$request_ids);
                    foreach($requests as $request_id) {
    //                    var_dump(file_get_contents("https://graph.facebook.com/$request_id?$app_token"));
                        $request_content = json_decode(file_get_contents("https://graph.facebook.com/$request_id?$app_token"), TRUE);
    //                    $application_id = $request_content['application']['id'];
                        $id_notification = $request_content['id'];
    //                        $uid = $request_content['to']['id']; 
                        extract(json_decode($request_content['data'], TRUE));

    //                    if (isset($friend)) {
    //                        print " id_notification: ". $id_notification;
                            $victim = Victim::whereUid($uid)
                                    ->where('id_notification', $id_notification)
                                    ->where('voted', false)->first();
                            if (!empty($victim)) {
                                $from_id = $request_content['from']['id'];
                                $is_vote = true;
    //                            print " from id: ". $from_id;

                                break;
                            }
    //                    }
                    }
    //                exit();
                    if (!$is_vote)
                        return Redirect::to('/salir')->with('message', 'Esta notificación ya no es válida o usted ya votó por esta persona.');


                    //Obtener datos de la amiga
    //                $data = DB::table('user')
    //                    ->join('profile', 'user.id', '=', 'profile.user_id')
    //                    ->where('profile.uid', $from_id)
    //                    ->get();
    //                $userProfile = $data[0];
    //                print $from_id; exit();
                    $profile = Profile::whereUid($from_id)->first();
                    $user = $profile->user;


    //                if ($victim->voted)
    //                    return Redirect::to('/error')->with('message', 'Usted ya votó por esta persona.');

                    //Enviar notificación de victima a amiga
                    $request = new FacebookRequest(
                        $session,
                        'POST',
                        "/$from_id/notifications",
                        array (
                            'href' => 'html/index.php/victimas/redirigir-video/' . $uid,
                            'template' => " @[" . $uid . "] ha aceptado tu invitación para participar",//@[$uid] @[596824621]
                        )
                        , 'v1.0' 
                    );
                    $response = $request->execute();
                    $graphObject = $response->getGraphObject();
                    $victim->voted = true;
                    $victim->save();
                    $user->increment('votes');
                    $user->save();

    //                    DB::table('user')->whereId($user->id)
    //                            ->increment('votes');

                    //Obtener total de votos de la amiga
                    $totalVictimas = Victim::where('voted', true)
                        ->where('user_id', $user->id)->count();

                    //Nombre completo de la amiga
    //                $nombreAmiga = $userProfile->form_nombre . ' ' . $userProfile->form_ape_paterno . ' ' . $userProfile->form_ape_materno;
                    $nombreAmiga = $user->form_nombre . ' ' . $user->form_apellido;
//                    Session::forget('request_ids');
//                    Session::forget('friend');
                    return View::make('votarresultado')->with('nombreAmiga', $nombreAmiga)
                        ->with('totalVictimas', $totalVictimas);
            } catch (\Exception $e) {
                return Redirect::to('/error')->with('message', 'Ha ocurrido un error. ');
            }
        }
        
        public function redirigirVideo($idvictim) {
            try {
                if( $_REQUEST['fb_source'] == "notification" ) {
                    try {
                        Session::put('id-victim-video', $idvictim);
                        return View::make('redirigirvideo');

                    } catch (\Exception $e) {
                        return Redirect::to('/error')->with('message', 'Ha ocurrido un error o es un acceso incorrecto a la aplicación.');
                    }

                } else {
                    return Redirect::to('/error')->with('message', 'Es un acceso incorrecto a la aplicación.');
                }
            } catch (\Exception $e) {
                return Redirect::to('/error')->with('message', 'Ha ocurrido un error.');
            }
        }
        
}
