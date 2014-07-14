<?php
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
use Facebook\Exceptions\FacebookRequestException;
use Facebook\FacebookRequest;

Route::post('/', array('before' => 'auth-facebook', 'uses' => 'HomeController@home'));
//Route::post('/', array('uses' => 'HomeController@home'));

Route::get('noliked', function()
{
     return View::make('noliked');
});

Route::get('noauth', function()
{
     return View::make('noauth');
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


Route::get('login/fb/callback', array('uses' => 'LoginController@fbCallback'));

Route::get('logout', function() {
    Auth::logout();
    return Redirect::to('/');
});

//Route::get('/inscripcion', array('uses' => 'InscripcionController@form'));
Route::get('/inscripcion', array('before' => 'auth-facebook', 'uses' => 'InscripcionController@form'));
Route::post('/inscripcion/save', array('before' => 'auth-facebook', 'uses' => 'InscripcionController@save'));
Route::get('/categorias', array('before' => 'auth-facebook', 'uses' => 'CategoryController@index'));
Route::get('/categorias/amigos/{idCate}', array('before' => 'auth-facebook', 'uses' => 'CategoryController@amigos'));

