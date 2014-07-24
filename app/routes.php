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
Route::model('user', 'User');

Route::post('/', array('before' => 'auth-facebook', 'uses' => 'HomeController@home'));
Route::get('/', array('uses' => 'HomeController@invite'));
//Route::post('/', array('uses' => 'HomeController@home'));

Route::get('noliked', function()
{
     return View::make('noliked');
});

Route::get('noauth', function()
{
     return View::make('noauth');
});

Route::get('error', function()
{
     return View::make('error');
});

Route::any('login/fb/callback', array('uses' => 'LoginController@fbCallback'));

Route::get('logout', function() {
    Auth::logout();
    return Redirect::to('/');
});

//Route::get('/inscripcion', array('uses' => 'InscripcionController@form'));
Route::get('inscripcion/{id}', array('as'  => 'inscripcion', 
    'uses' => 'InscripcionController@form'));//'before' => 'auth-js-facebook', 
Route::post('inscripcion/update/{id}', array('as'  => 'inscripcion.update', 
    'before' => 'auth-js-facebook|csrf', 'uses' => 'InscripcionController@update'))->where('id', '[0-9]+');
Route::get('categorias', array('as'  => 'categorias', 
    'before' => 'auth', 'uses' => 'CategoryController@index'));//auth-js-facebook|
Route::any('categorias/amigos/{idCate}', array('before' => 'auth', 'uses' => 'CategoryController@amigos'));//auth-facebook|

Route::post('victimas/registrarvictimas/{idCate}', array('as'  => 'victim.savevictims', 
    'before' => 'auth', 'uses' => 'VictimController@savevictims'));//auth-facebook|

Route::any('victimas/votar', array('as'  => 'victim.votar', 
    'uses' => 'VictimController@votar'));//auth-facebook|

Route::get('nopermitdo', function() {
    return View::make('nopermitido')->with('message', "Sólo pueden concursar chicas!");
});

Route::get('ranking', array('as'  => 'ranking', 
    'uses' => 'RankingController@index'));//auth-js-facebook|
