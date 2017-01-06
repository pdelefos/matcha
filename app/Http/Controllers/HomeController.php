<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\Validator;
use App\Classes\ErrorHandler;
use App\Classes\Session;
use App\Models\Interest;

class HomeController extends Controller
{

    public function __construct()
    {
        //
    }

    public function showHome(Request $request) {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $user_completed = User::getCompleted($user_id);
        $interests = Interest::getInterests();
        return view('pages.home.home',
        [
            'interests' => $interests, 
            'user_completed' => $user_completed,
            'request' => $request
        ]);
        // return view('pages.home.home');
    }

    public function submitProfile(Request $request) {
        $session = Session::getInstance();
        $inputs = $request->all();
        $errorHandler = new ErrorHandler;
        $validator = new Validator($errorHandler);
        $validator->check($inputs, [
            'sexe' => [
                'required' => true
            ],
            'recherche' => [
                'required' => true
            ],
            'anniversaire' => [
                'requiredDate' => true,
                'validDate' => true
            ],
            'presentation' => [
                'required' => true
            ],
            'interets' => [
                'requiredTagsMin' => 2,
                'requiredTagsMax' => 5
            ],
            'adresse' => [
                'required' => true
            ]
        ]);
        if ($validator->fails()) {
            $user_completed = User::getCompleted($session->getValue('id'));
            $interests = Interest::getInterests();
            return view('pages.home.home',
            [
                'prev_values' => $request,
                'errorHandler' => $validator->errors(),
                'interests' => $interests,
                'user_completed' => $user_completed,
                'request' => $request
            ]);
        } else {
            $jour = $inputs['anniversaire']['jour'];
            $mois = $inputs['anniversaire']['mois'];
            $annee = $inputs['anniversaire']['annee'];
            $date = $mois . "/" . $jour . "/" . $annee;
            $user = new User();
            $user->setId($session->getValue('id'));
            $user->setSexe($inputs['sexe']);
            $user->setOrientation($inputs['recherche']);
            $user->setAnniversaire($date);
            $user->setLocalisation($inputs['adresse']);
            $user->setPresentation($inputs['presentation']);
            $user->setInterests($inputs['interets']);
            $user->completeProfile();
            return redirect()->route('home');
        }
    }

    public function showProfile(Request $request, $login) {
        $login = htmlentities($login);
        if ($login == 'me') {
            $session = Session::getInstance();
            $user = User::getUser($session->getValue('id'));
            return view('pages.home.myprofil', ['user' => $user, 'request' => $request, 'modification' => false]);
        } elseif (User::loginExists($login)) {
            $user = User::getUser(User::getId($login));
            return view('pages.home.profil', ['user' => $user, 'request' => $request]);
        } else {
            return view('errors.profil', ['login' => $login, 'request' => $request]);
        }
    }

    public function modificationProfile(Request $request) {
        $session = Session::getInstance();
        $user = User::getUser($session->getValue('id'));
        $interests = Interest::getInterests();
        return view('pages.home.myprofil',
        [
            'user' => $user,
            'request' => $request,
            'interests' => $interests, 
            'modification' => true
        ]);
    }

    public function submitModificationProfile(Request $request) {
        
    }

    public function showNotif(Request $request) {
        return view('pages.home.notification',
        [
            'request' => $request
        ]);
    }

    public function showChat(Request $request) {
        return view('pages.home.chat',
        [
            'request' => $request
        ]);
    }
}