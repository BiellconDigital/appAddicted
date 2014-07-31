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
                    $data = DB::table('user')
                        ->join('profile', 'user.id', '=', 'profile.user_id')
                        ->where('user.id', $victim->user_id)
                        ->get();
                    $userProfile = $data[0];
                    
                    Session::put('from_id', $userProfile->uid);
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
                    // Requesting an application token
                    $token_url =    "https://graph.facebook.com/oauth/access_token?" .
                    "client_id=" . Config::get('facebook')['appId'] .
                    "&client_secret=" . Config::get('facebook')['secret'] .
                    "&grant_type=client_credentials";
                    $app_token = file_get_contents($token_url);
                    //echo $app_token;

                    $requests = explode(',',$_REQUEST['request_ids']);
                    //echo Session::get('from_id');
                    foreach($requests as $request_id) {
                        // Get the request details using Graph API
                        $request_content = json_decode(file_get_contents("https://graph.facebook.com/$request_id?$app_token"), TRUE);
                         // An example of how to get info from the previous call

                        $application_id = $request_content['application']['id'];
                        $from_id = $request_content['from']['id'];
//                        $to_id = $request_content['to']['id']; 
                        //echo $from_id . ", ";
                        // An easier way to extract info from the data field
                        extract(json_decode($request_content['data'], TRUE));
                        if (isset($friend)) {
                            //echo $friend . "... ";
				$_SESSION['from_id'] = $from_id;
Session::put('friend', $friend);
/*
			    if (Session::has('from_id'))
				Session::forget('from_id');
                            Session::put('from_id', $from_id);
                            Session::put('friend', $friend);
*/
//echo 'from: ' . Session::get('from_id');
//                            Session::put('to_id', $to_id);
                            return View::make('invite');
                        }
                        //echo "id: " . $id;
                        // Now that we got the $item_id and the $item_type, process them
                        // Or if the recevier is not yet a member, encourage him to claims his item (install your application)! 
    //                    $redirect_from_app = $fbconfig['appUrl'] . "&app_data=" . $item_id;
    //                    $loginUrl = $facebook->getLoginUrl(array('scope' => 'email,publish_stream', 'redirect_uri' => $redirect_from_app));
                        // When all is done, delete the requests because Facebook will not do it for you!
                        //$deleted = file_get_contents("https://graph.facebook.com/$request_id?$app_token&method=delete"); // Should return true on success
                    }
//exit();
                    return Redirect::to('/error')->with('message', 'Es un acceso incorrecto a la aplicación.');
                } catch (\Exception $e) {
                    return Redirect::to('/error')->with('message', 'Ha ocurrido un error o es un acceso incorrecto a la aplicación. ' .$e->getMessage());
                }

            }
        }
}
