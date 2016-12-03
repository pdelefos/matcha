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

$app->get('/home/deconnexion', ['as' => 'deconnexion', 'uses' => 'AuthController@logout']);

/*--------------------------------------------------------------------------
| Home Routes 															   |
--------------------------------------------------------------------------*/

$app->group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function () use ($app) {
    $app->get('/home', ['as' => 'home', 'uses' => 'HomeController@showHome']);

    $app->get('/home/profile', ['as' => 'profile', 'uses' => 'HomeController@showProfile']);

    $app->get('/home/notifications', ['as' => 'notif', 'uses' => 'HomeController@showNotif']);

    $app->get('/home/chat', ['as' => 'chat', 'uses' => 'HomeController@showChat']);
});