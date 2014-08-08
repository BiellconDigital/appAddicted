<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/
use Facebook\FacebookSession;
use Facebook\Helpers\FacebookPageTabHelper;
use Facebook\Helpers\FacebookJavaScriptLoginHelper;
use Facebook\Exceptions\FacebookAuthorizationException;

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
                    Redirect::to('/sesionexpirada')->with('message', 'Su sesión ha expirado. Por favor haga click en reiniciar.');
                    //return Redirect::guest('login');
		}
	}
});

Route::filter('auth-participant', function()
{
	if (!Session::has('participant'))
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('auth-facebook', function()
{
    try {
        
        if(Session::has('friend')) {
            Session::forget('friend');
        }
            
        
                if( isset($_REQUEST['request_ids']) ) {
                    try {
                        Session::put('friend', 'yes');
                        return View::make('invite')->with('request_ids', $_REQUEST['request_ids']);
                    } catch (\Exception $e) {
                        return Redirect::to('/error')->with('message', 'Ha ocurrido un error o es un acceso incorrecto a la aplicación. ');
                    }

                }

        FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);

        $pageHelper = new FacebookPageTabHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);

        $signed_request = $_REQUEST['signed_request'];
        $data_signed_request = explode('.',$signed_request); // Get the part of the signed_request we need.
        $jsonData = base64_decode($data_signed_request['1']); // Base64 Decode signed_request making it JSON.
        $objData = json_decode($jsonData,true); // Split the JSON into arrays.
        if (isset($objData['app_data'])) {
            $sourceData = $objData['app_data']; // yay you got the damn data in an string, slow c
            Session::put('app_data', $sourceData);
            Session::put('friend', 'yes');
    //        setcookie("app_data", $sourceData, time()+1500);
        }

        $isLiked = $pageHelper->isLiked();//https://developers.facebook.com/docs/apps/review
        if (!$isLiked) {
            return View::make('noliked');//->with('message', 'PRIMERO DALE ME GUSTA ');
            //return Redirect::to('/fb/noauth')->with('url', $helper->getLoginUrl(array('email', 'user_friends')));
            //return Redirect::to('/inscripcion')->with('url', $helper->getLoginUrl(array('email', 'user_friends')));
        }
        $session = $pageHelper->getSession();

        if(!isset($session))
        {
            if (isset($objData['app_data']))
                return View::make('noauth')->with('app_data', $sourceData);
            else 
                return View::make('noauth')->with('app_data', "0");
        }
        Session::put('uid', $pageHelper->getUserId());
//        Session::put('app_data', $session->getSignedRequestProperty('app_data'));
        
    } catch (FacebookAuthorizationException $e) {
        return Redirect::to('/sesionexpirada')->with('message', 'Su sesión ha expirado. Por favor haga click en reiniciar.');
    }
});

Route::filter('auth-js-facebook', function()
{
    try {
        FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);
        $pageHelper = new FacebookJavaScriptLoginHelper();

        $session = $pageHelper->getSession();
        if(!isset($session))
        {
            return Redirect::to('/noauth')->with('app_data', "0");//->with('message', 'No esta autorizado.');
                    //->with('url', $helper->getLoginUrl(array('email', 'user_friends')));
        }
        Session::put('uid', $pageHelper->getUserId());
    } catch (FacebookAuthorizationException $e) {
        return Redirect::to('/sesionexpirada')->with('message', 'Su sesión ha expirado. Por favor haga click en reiniciar.');
    }
});
