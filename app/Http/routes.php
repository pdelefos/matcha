<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Http\Request;

/*--------------------------------------------------------------------------
| Home Route 															   |
--------------------------------------------------------------------------*/

$app->get('/home', function(Request $request) {
	return view('pages.home');
});

/*--------------------------------------------------------------------------
| Authentification Routes 												   |
--------------------------------------------------------------------------*/

$app->get('/', ['as' => 'root', 'uses' => 'AuthController@showRegister']);

$app->post('/', "AuthController@submitRegister");

$app->get('/connexion', ['as' => 'connection', 'uses' => 'AuthController@showConnexion']);

$app->post('/connexion', "AuthController@submitConnexion");