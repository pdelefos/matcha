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

// Inscription

$app->get('/', ['as' => 'root', 'uses' => 'AuthController@showRegister']);
 
$app->post('/', "AuthController@submitRegister");

// Connexion

$app->get('/connexion', ['as' => 'connection', 'uses' => 'AuthController@showConnexion']);

$app->post('/connexion', "AuthController@submitConnexion");

// Recuperation de mot de passe

$app->get('/recover', ['as' => 'recover', 'uses' => 'AuthController@showRecover']);

$app->post('/recover', "AuthController@submitRecover");

// Déconnexion

$app->get('/home/deconnexion', ['as' => 'deconnexion', 'uses' => 'AuthController@logout']);

/*--------------------------------------------------------------------------
| Home Routes 															   |
--------------------------------------------------------------------------*/

$app->group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function () use ($app) {

    // Route de suggestion et de recherche d'utilisateurs

    $app->get('/home', ['as' => 'home', 'uses' => 'HomeController@showHome']);

    $app->post('/home', ['as' => 'home', 'uses' => 'UserController@submitProfile']);

    // Route du profil de l'utilisateur

    $app->get('/home/profil/{login}', ['as' => 'profile', 'uses' => 'UserController@showProfile']);

    $app->get('/home/modification', ['as' => 'modification', 'uses' => 'UserController@modificationProfile']);

    $app->post('/home/modification', ['as' => 'modification', 'uses' => 'UserController@submitModificationProfile']);

    $app->get('/home/profilpic', ['as' => 'profilpic', 'uses' => 'UserController@showProfilPic']);

    $app->post('/home/profilpic', ['as' => 'profilpic', 'uses' => 'UserController@submitProfilPic']);

    $app->get('/home/photo/{no}', ['as' => 'photo', 'uses' => 'UserController@showPhotos']);

    $app->post('/home/photo', ['as' => 'photo', 'uses' => 'UserController@submitPhotos']);

    // Route des notifications

    $app->get('/home/notifications', ['as' => 'notif', 'uses' => 'NotifController@showNotif']);

    // Route du chat

    $app->get('/home/chat', ['as' => 'chat', 'uses' => 'ChatController@showChat']);
});

/*--------------------------------------------------------------------------
| Error Routes 															   |
--------------------------------------------------------------------------*/

$app->get('/404', ['as' => '404', function () {
    return view('errors.404');
}]);