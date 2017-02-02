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

$app->get('/connexion', ['as' => 'connection',
            'uses' => 'AuthController@showConnexion']);

$app->post('/connexion', "AuthController@submitConnexion");

// Recuperation de mot de passe

$app->get('/recover', ['as' => 'recover',
            'uses' => 'AuthController@showRecover']);

$app->post('/recover', "AuthController@submitRecover");

// Déconnexion

$app->get('/home/deconnexion', ['as' => 'deconnexion',
            'uses' => 'AuthController@logout']);

/*--------------------------------------------------------------------------
| Home Routes 															   |
--------------------------------------------------------------------------*/

$app->group(['middleware' => 'auth',
                'namespace' => 'App\Http\Controllers'], function () use ($app) {

    // Route de suggestion et de recherche d'utilisateurs

    $app->get('/home', ['as' => 'home', 'uses' => 'HomeController@showHome']);

    $app->post('/home', ['as' => 'home',
                'uses' => 'UserController@submitProfile']);

    $app->get('/recherche', ['as' => 'recherche', 
                'uses' => 'HomeController@showSearch']);

    $app->post('/recherche', ['as' => 'recherche', 
                'uses' => 'HomeController@submitSearch']);

    // Route du profil de l'utilisateur

    $app->get('/profil/user/{login}', ['as' => 'profile',
                'uses' => 'UserController@showProfile']);

    $app->get('/profil/modification', ['as' => 'modification',
                'uses' => 'UserController@modificationProfile']);

    $app->post('/profil/modification', ['as' => 'modification',
                'uses' => 'UserController@submitModificationProfile']);

    $app->get('/profil/profilpic', ['as' => 'profilpic',
                'uses' => 'UserController@showProfilPic']);

    $app->post('/profil/profilpic', ['as' => 'profilpic',
                'uses' => 'UserController@submitProfilPic']);

    $app->get('/profil/photo/{no}', ['as' => 'photo',
                'uses' => 'UserController@showPhotos']);

    $app->post('/profil/photo', ['as' => 'photo',
                'uses' => 'UserController@submitPhotos']);

    $app->get('/profil/bloquer/{login}', ['as' => 'block',
                'uses' => 'UserController@blockUser']);

    // Route des notifications

    $app->get('/notifications', ['as' => 'notif',
                'uses' => 'NotifController@showNotif']);

    $app->get('/notifications/getnotif', ['as' => 'getnotif',
                'uses' => 'NotifController@getNotif']);

    $app->get('/notifications/userisonline/{login}', ['as' => 'userIsOnline',
                'uses' => 'NotifController@isOnline']);

    $app->get('/like/{login}', ['as' => 'like',
                'uses' => 'NotifController@likeUser']);

    // Route du chat

    $app->get('/chat', ['as' => 'chat', 'uses' => 'ChatController@showChat']);
});

/*--------------------------------------------------------------------------
| Error Routes 															   |
--------------------------------------------------------------------------*/

$app->get('/404', ['as' => '404', function () {
    return view('errors.404');
}]);