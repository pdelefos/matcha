<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\Validator;
use App\Classes\ErrorHandler;
use App\Classes\Session;
use App\Models\Interest;
use App\Models\Geolocalisation;

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
                'required' => true,
                'isValidAddress' => true
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
            if (empty($inputs['adresseLat']) || empty($inputs['adresseLng'])) {
                $ret = Geolocalisation::getLatLngFromAddress($inputs['adresse']);
                $inputs['adresseLat'] = $ret['lat'];
                $inputs['adresseLng'] = $ret['lng'];
            }
            $user->setLatitude($inputs['adresseLat']);
            $user->setLongitude($inputs['adresseLng']);
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
            return view('pages.home.myprofil', [
                'user' => $user,
                'request' => $request,
                'modification' => false,
                'modPicture' => false
            ]);
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
        return view('pages.home.myprofil',
        [
            'user' => $user,
            'request' => $request,
            'modification' => true,
            'modPicture' => false
        ]);
    }

    public function submitModificationProfile(Request $request) {
        $session = Session::getInstance();
        $inputs = $request->all();
        $errorHandler = new ErrorHandler;
        $validator = new Validator($errorHandler);
        $validator->check($inputs, [
            'nom' => [
                'required' => true,
                'alnum' => true,
                'maxlength' => 150
            ],
            'prenom' => [
                'required' => true,
                'alnum' => true,
                'maxlength' => 150
            ],
            'email' => [
                'required' => true,
                'email' => true,
                'updateEmail' => true
            ],
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
                'required' => true,
                'isValidAddress' => true
            ]
        ]);
        if ($validator->fails()) {
            $user = User::getUser($session->getValue('id'));
            return view('pages.home.myprofil',
            [
                'user' => $user,
                'errorHandler' => $validator->errors(),
                'request' => $request,
                'modification' => true,
                'modPicture' => false
            ]);
        } else {
            $jour = $inputs['anniversaire']['jour'];
            $mois = $inputs['anniversaire']['mois'];
            $annee = $inputs['anniversaire']['annee'];
            $date = $mois . "/" . $jour . "/" . $annee;
            $user = new User();
            $user->setId($session->getValue('id'));
            $user->setNom($inputs['nom']);
            $user->setPrenom($inputs['prenom']);
            $user->setEmail($inputs['email']);
            $user->setSexe($inputs['sexe']);
            $user->setOrientation($inputs['recherche']);
            $user->setAnniversaire($date);
            $user->setLocalisation($inputs['adresse']);
            if (empty($inputs['adresseLat']) || empty($inputs['adresseLng'])) {
                $ret = Geolocalisation::getLatLngFromAddress($inputs['adresse']);
                $inputs['adresseLat'] = $ret['lat'];
                $inputs['adresseLng'] = $ret['lng'];
            }
            $user->setLatitude($inputs['adresseLat']);
            $user->setLongitude($inputs['adresseLng']);
            $user->setPresentation($inputs['presentation']);
            $user->setInterests($inputs['interets']);
            $user->updateProfile();
            $session = Session::getInstance();
            $user = User::getUser($session->getValue('id'));
            return view('pages.home.myprofil', [
                'user' => $user,
                'request' => $request,
                'modification' => false,
                'modPicture' => false
            ]);
        }
    }

    public function showProfilPic(Request $request) {
        $session = Session::getInstance();
        $user = User::getUser($session->getValue('id'));
        return view('pages.home.myprofil',
        [
            'user' => $user,
            'request' => $request,
            'modification' => false,
            'modPicture' => true
        ]);
    }

    public function submitProfilPic(Request $request) {
        if ($request->file('picture')->isValid()){
            $file = $request->file('picture');
            $file->move("pictures", "pic.jpg");
            $ret = false;
        } else {
            echo $request->file('picture')->getErrorMessage();
            $ret = true;
        }
        $session = Session::getInstance();
        $user = User::getUser($session->getValue('id'));
        return view('pages.home.myprofil',
        [
            'user' => $user,
            'request' => $request,
            'modification' => false,
            'modPicture' => $ret
        ]);
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