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
        return view('pages.home.home', ['interests' => Interest::getInterests()]);
    }

    public function submitProfile(Request $request) {
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
        // if ($validator->fails()) {
        //     return view('pages.home.home', ['prev_values' => $request, 'errorHandler' => $validator->errors()]);
        // } else {
            // $jour = $inputs['anniversaire']['jour'];
            // $mois = $inputs['anniversaire']['mois'];
            // $annee = $inputs['anniversaire']['annee'];
            // $date = $mois . "/" . $jour . "/" . $annee;
            // $session = Session::getInstance();
            // $user = new User();
            // $user->setId($session->getValue('id'));
            // $user->setSexe($inputs['sexe']);
            // $user->setOrientation($inputs['recherche']);
            // $user->setAnniversaire($date);
            // $user->setPresentation($inputs['presentation']);
            // $user->completeProfile();
            // Interest::saveInterests(1, $inputs['interets']);
        // }
    }

    public function showProfile() {
        return view('pages.home.profile');
    }

    public function showNotif() {
        return view('pages.home.notification');
    }

    public function showChat() {
        return view('pages.home.chat');
    }
}