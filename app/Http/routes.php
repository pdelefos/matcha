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
| Authentification Routes 												   |
--------------------------------------------------------------------------*/

$app->get('/', ['as' => 'root', 'uses' => 'AuthController@showRegister']);
 
$app->post('/', "AuthController@submitRegister");

$app->get('/connexion', ['as' => 'connection', 'uses' => 'AuthController@showConnexion']);

$app->post('/connexion', "AuthController@submitConnexion");

/*--------------------------------------------------------------------------
| Home Routes 															   |
--------------------------------------------------------------------------*/

$app->get('/home', ['as' => 'home', 'uses' => 'HomeController@showHome']);

$app->get('/profile', ['as' => 'profile', 'uses' => 'HomeController@showProfile']);

$app->get('/notifications', ['as' => 'notif', 'uses' => 'HomeController@showNotif']);

$app->get('/chat', ['as' => 'chat', 'uses' => 'HomeController@showChat']);