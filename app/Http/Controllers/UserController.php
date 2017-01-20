<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\Validator;
use App\Classes\ErrorHandler;
use App\Classes\Session;
use App\Models\Interest;
use App\Models\Geolocalisation;
use App\Models\Photo;
use App\Models\Tool;

class UserController extends Controller {

    public function __construct()
    {
        //
    }

    // Render le profil de l'utilisateur
    public function showProfile(Request $request, $login) {
        $login = htmlentities($login);
        if ($login == 'me') {
            $session = Session::getInstance();
            $user = User::getUser($session->getValue('id'));
            return view('pages.home.myprofil', [
                'user' => $user,
                'request' => $request,
                'modification' => false,
                'modPicture' => false,
                'modPhotos' => false
            ]);
        } elseif (User::loginExists($login)) {
            $user = User::getUser(User::getId($login));
            $session = Session::getInstance();
            $current = User::getUser($session->getValue('id'));
            if ($current->isBlocked(User::getId($login)))
                return view('errors.blocked', ['user' => $user, 'request' => $request]);
            return view('pages.home.profil', ['user' => $user, 'request' => $request]);
        } else {
            return view('errors.profil', ['login' => $login, 'request' => $request]);
        }
    }

    // Enregistre les informations supplementaires
    public function submitProfile(Request $request) {
        $session = Session::getInstance();
        $inputs = $request->all();
        $checkInputs = Tool::checkInputs($inputs, [
            'sexe',
            'recherche',
            'anniversaire',
            'presentation',
            'interets',
            'adresse'
        ]);
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
        if ($validator->fails() || !$checkInputs) {
            $user_completed = User::getUserCompleted($session->getValue('id'));
            $session = Session::getInstance();
            $user = User::getUser($session->getValue('id'));
            $interests = Interest::getInterests();
            return view('pages.home.home',
            [
                'user' => $user,
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
            $date = $jour . "/" . $mois . "/" . $annee;
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

    // Render la modal de modification de profil
    public function modificationProfile(Request $request) {
        $session = Session::getInstance();
        $user = User::getUser($session->getValue('id'));
        $interests = Interest::getInterests();
        return view('pages.home.myprofil',
        [
            'user' => $user,
            'request' => $request,
            'interests' => $interests,
            'modification' => true,
            'modPicture' => false,
            'modPhotos' => false
        ]);
    }

    // Enregistre les modifications du profil
    public function submitModificationProfile(Request $request) {
        $session = Session::getInstance();
        $inputs = $request->all();
        $checkInputs = Tool::checkInputs($inputs, [
            'nom',
            'prenom',
            'email',
            'sexe',
            'recherche',
            'anniversaire',
            'presentation',
            'interets',
            'adresse',
            'adresseLat',
            'adresseLng'
        ]);
        $errorHandler = new ErrorHandler;
        $validator = new Validator($errorHandler);
        $interests = Interest::getInterests();
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
        if ($validator->fails() || !$checkInputs) {
            $user = User::getUser($session->getValue('id'));
            return view('pages.home.myprofil',
            [
                'user' => $user,
                'errorHandler' => $validator->errors(),
                'request' => $request,
                'interests' => $interests,
                'modification' => true,
                'modPicture' => false,
                'modPhotos' => false
            ]);
        } else {
            $jour = $inputs['anniversaire']['jour'];
            $mois = $inputs['anniversaire']['mois'];
            $annee = $inputs['anniversaire']['annee'];
            $date = $jour . "/" . $mois . "/" . $annee;
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
                'interests' => $interests,
                'modification' => false,
                'modPicture' => false,
                'modPhotos' => false
            ]);
        }
    }

    // Render la modal de photo de profil
    public function showProfilPic(Request $request) {
        $session = Session::getInstance();
        $user = User::getUser($session->getValue('id'));
        return view('pages.home.myprofil',
        [
            'user' => $user,
            'request' => $request,
            'modification' => false,
            'modPicture' => true,
            'modPhotos' => false
        ]);
    }

    // Enregistre la photo de profil
    public function submitProfilPic(Request $request) {
        $errorHandler = new ErrorHandler;
        $file = $request->file('picture');
        $inputs = $request->all();
        $checkInputs = Tool::checkInputs($inputs, [
            'picture',
            'photoNo',
            'submit'
        ]);
        $session = Session::getInstance();
        $user = User::getUser($session->getValue('id'));
        if ($file == null) {
            $errorHandler->addError("fichier invalid", "fichier");
            $ret = true;
        } elseif ($file == null || !$file->isValid()) {
            $errorHandler->addError($request->file('picture')->getErrorMessage(), "fichier");
            $ret = true;
        } elseif ($file->guessExtension() == "jpeg" ||
                  $file->guessExtension() == "png" ||
                  $file->guessExtension() == "gif"){
            $path = "pictures/" . $user->getLogin();
            $filename = "avatar." . $file->guessExtension();
            $fullPath = $path . "/" . $filename;
            $file->move($path, $filename);
            Photo::setUserAvatar($session->getValue('id'), $fullPath);
            $ret = false;
        } else {
            $errorHandler->addError("extension invalide", "fichier");
            $ret = true;
        }
        return view('pages.home.myprofil',
        [
            'user' => $user,
            'request' => $request,
            'modification' => false,
            'errorHandler' => $errorHandler,
            'modPicture' => $ret,
            'modPhotos' => false
        ]);
    }

    // Render la modal de photo
    public function showPhotos(Request $request, $no) {
        $errorHandler = new ErrorHandler;
        $session = Session::getInstance();
        $user = User::getUser($session->getValue('id'));
        if ($no != '1' && $no != '2' && $no != '3' && $no != '4')
            return view('pages.home.myprofil',
            [
                'user' => $user,
                'request' => $request,
                'modification' => false,
                'errorHandler' => $errorHandler,
                'modPicture' => false,
                'modPhotos' => false
            ]);
        return view('pages.home.myprofil',
        [
            'user' => $user,
            'request' => $request,
            'modification' => false,
            'errorHandler' => $errorHandler,
            'modPicture' => false,
            'modPhotos' => true,
            'photoNo' => $no
        ]);
    }

    // Enregistre une photo
    public function submitPhotos(Request $request) {
        $errorHandler = new ErrorHandler;
        $inputs = $request->all();
        $file = $request->file('picture');
        $session = Session::getInstance();
        $user = User::getUser($session->getValue('id'));
        $ret = true;
        if (Tool::checkInputs($inputs, ['photoNo'])){
            if ($file == null) {
                $errorHandler->addError("fichier invalid", "fichier");
                $ret = true;
            } elseif ($file == null || !$file->isValid()) {
                $errorHandler->addError($request->file('picture')->getErrorMessage(), "fichier");
                $ret = true;
            } elseif ($file->guessExtension() == "jpeg" ||
                    $file->guessExtension() == "png" ||
                    $file->guessExtension() == "gif"){
                $path = "pictures/" . $user->getLogin();
                $filename = $inputs['photoNo'] . "." . $file->guessExtension();
                $fullPath = $path . "/" . $filename;
                Photo::setUserPhoto($session->getValue('id'), $fullPath, $inputs['photoNo']);
                $file->move($path, $filename);
                $ret = false;
            } else {
                $errorHandler->addError("extension invalide", "fichier");
                $ret = true;
            }
        }
        return view('pages.home.myprofil',
        [
            'user' => $user,
            'request' => $request,
            'modification' => false,
            'errorHandler' => $errorHandler,
            'modPicture' => false,
            'modPhotos' => $ret
        ]);
    }

    public function blockUser(Request $request, $login) {
        // var_dump($login);
        // die();
        $session = Session::getInstance();
        $user = User::getUser($session->getValue('id'));
        $blocked_id = User::getId($login);
        if (!$user->isBlocked($blocked_id)){
            $user->block($blocked_id);
            return redirect()->route('home');
        } else {
            $user->unblock($blocked_id);
            return redirect()->route('profile', ['login' => $login]);
        }
    }
}