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
        FacebookSession::setDefaultApplication(Config::get('facebook')['appId'],Config::get('facebook')['secret']);

        $pageHelper = new FacebookPageTabHelper(Config::get('facebook')['appId'],Config::get('facebook')['secret']);

        $isLiked = $pageHelper->isLiked();//https://developers.facebook.com/docs/apps/review
        if (!$isLiked) {
            return Redirect::to('/noliked');//->with('message', 'PRIMERO DALE ME GUSTA ');
            //return Redirect::to('/fb/noauth')->with('url', $helper->getLoginUrl(array('email', 'user_friends')));
            //return Redirect::to('/inscripcion')->with('url', $helper->getLoginUrl(array('email', 'user_friends')));
        }
        $session = $pageHelper->getSession();

        if(!isset($session))
        {
            // Login URL if session not found
            //return Redirect::to('/fb/noliked')->with('message', 'PARTICIPA ');
            return Redirect::to('/noauth');//->with('message', 'No esta autorizado.');
                    //->with('url', $helper->getLoginUrl(array('email', 'user_friends')));
        }
        Session::put('uid', $pageHelper->getUserId());
        
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
            return Redirect::to('/noauth');//->with('message', 'No esta autorizado.');
                    //->with('url', $helper->getLoginUrl(array('email', 'user_friends')));
        }
        Session::put('uid', $pageHelper->getUserId());
    } catch (FacebookAuthorizationException $e) {
        return Redirect::to('/sesionexpirada')->with('message', 'Su sesión ha expirado. Por favor haga click en reiniciar.');
    }
});
