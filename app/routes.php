<?php
session_start();
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
Route::get('/', function()
{
	return View::make('hello');
});
*/
use Facebook\FacebookSession;
use Facebook\Helpers\FacebookRedirectLoginHelper;
use Facebook\Helpers\FacebookCanvasLoginHelper;
use Facebook\Helpers\FacebookPageTabHelper;
use Facebook\Helpers\FacebookSignedRequestFromInputHelper;
use Facebook\Exceptions\FacebookRequestException;
use Facebook\FacebookRequest;


Route::get('/', function()
{
    $data = array();
    $signed_request = "nada";
    FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
    
//    $helper = new FacebookCanvasLoginHelper();
//    $he = FacebookSignedRequestFromInputHelper::class;
    
    // init login helper
    $helper = new FacebookRedirectLoginHelper( Config::get('app')['url'] . '/login/fb/callback' );

    // init page tab helper
    $pageHelper = new FacebookPageTabHelper();
    $pageHelper->state = "12345FDFDGFD22";
    $pageHelper->instantiateSignedRequest();
    // get session from the page
    $session = $pageHelper->getSession();
    
    $srGet = $pageHelper->getRawSignedRequest();
    var_dump($srGet);
    
    $srPost = $pageHelper->getRawSignedRequestFromPost();
    var_dump($srPost);
    
    $srCookie = $pageHelper->getRawSignedRequestFromCookie();
    var_dump($srCookie);
    
    $isLiked = $pageHelper->isLiked();
    if (!$isLiked) {
        return Redirect::to('/fb/noliked')->with('message', 'PRIMERO DALE ME GUSTA ');
    }
    if (Auth::check()) {
        $data = Auth::user();
    }
    
//    try {
//      $session = $helper->getSession();
//    } catch (FacebookRequestException $ex) {
//            Session::flash('message', $ex->getMessage());
//    } catch (\Exception $ex) {
//            Session::flash('message', $ex->getMessage());
//    }
    //$graphObject = "nada";
//    if ($session) {
//        $request = new FacebookRequest(
//          $session,
//          'GET',
//          '/me/likes/217498855042371'
//        );
//        $response = $request->execute();
//        $graphObject = $response->getGraphObject();
  //  }
    return View::make('user', array('data'=>$data, 'data2'=>$signed_request));
});

Route::get('fb/noliked', function()
{
     return View::make('noliked');
});

Route::get('login/fb', function() {
//    dd(Config::get('facebook'));
    FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
    
//    $facebook = new Facebook(Config::get('facebook'));
// Login Healper with reditect URI
    $helper = new FacebookRedirectLoginHelper( Config::get('app')['url'] . '/login/fb/callback' );

    try {
         $session = $helper->getSessionFromRedirect();
        //$loginUrl = $helper->getLoginUrl();
    } catch(FacebookRequestException $ex) {
      // When Facebook returns an error
        echo "FacebookRequestException:: " . $ex->getMessage();
    } catch(\Exception $ex) {
      // When validation fails or other local issues
//        echo "Exception 1:: " . $ex->getMessage();
        
    }
    if(isset($session))
    {
      // Request for user data
      $request = new FacebookRequest( $session, 'GET', '/me' );
      $response = $request->execute();
      // Responce
      $data = $response->getGraphObject();

      // Print data
      echo  print_r( $data, 1 );
    }
    else
    {
        return Redirect::to($helper->getLoginUrl(array('email', 'user_friends')));
    }    
});


Route::get('login/fb/callback', function() {
    $code = Input::get('code');
    if (strlen($code) == 0) return Redirect::to('/')->with('message', 'There was an error communicating with Facebook');
    
    $facebook = new Facebook(Config::get('facebook'));
    $uid = $facebook->getUser();
     
    if ($uid == 0) return Redirect::to('/')->with('message', 'There was an error');
     
    $me = $facebook->api('/me');

	$profile = Profile::whereUid($uid)->first();
    if (empty($profile)) {

    	$user = new User;
    	$user->name = $me['first_name'].' '.$me['last_name'];
    	$user->email = $me['email'];
    	$user->photo = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';

        $user->save();

        $profile = new Profile();
        $profile->uid = $uid;
    	$profile->username = $me['username'];
    	$profile = $user->profiles()->save($profile);
    }
     
    $profile->access_token = $facebook->getAccessToken();
    $profile->save();

    $user = $profile->user;
 
    Auth::login($user);
     
    return Redirect::to('/')->with('message', 'Logged in with Facebook');
});


Route::get('logout', function() {
    Auth::logout();
    return Redirect::to('/');
});

Route::any("/inscripcion/form", 'InscripcionController@form');
Route::any("/inscripcion/save", 'InscripcionController@save');
