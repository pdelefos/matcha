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

    public function showHome() {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $user_completed = User::getCompleted($user_id);
        $interests = Interest::getInterests();
        return view('pages.home.home',
        [
            'interests' => $interests, 
            'user_completed' => $user_completed
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
                'requiredTags' => 4
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
                'user_completed' => $user_completed
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

    public function showProfile() {
        $session = Session::getInstance();
        $user = User::getUser($session->getValue('id'));
        return view('pages.home.profile',
        [
            'user' => $user
        ]);
    }

    public function showNotif() {
        return view('pages.home.notification');
    }

    public function showChat() {
        return view('pages.home.chat');
    }
}