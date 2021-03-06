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
use App\Models\Likes;
use App\Models\Visit;
use App\Models\Notification;

class UserController extends Controller {

    public function __construct()
    {
        //
    }

    // Render le profil de l'utilisateur
    public function showProfile(Request $request, $login) {
        $session = Session::getInstance();
        $login = htmlentities($login);
        if ($login == 'me' || $login == $session->getValue('login')) {
            $user = User::getUser($session->getValue('id'));
            return view('pages.home.myprofil', [
                'user' => $user,
                'request' => $request,
                'modification' => false,
                'modPicture' => false,
                'modPhotos' => false
            ]);
        } elseif (User::loginExists($login)) {
            $current = User::getUser($session->getValue('id'));
            $other_id = User::getUserId($login);
            $user = User::getUser($other_id);
            $likeStatus = Likes::getStatus($other_id);
            if ($current->isBlocked($other_id))
                return view('errors.blocked', ['user' => $user, 'request' => $request]);
            Visit::visit($other_id);
            Notification::setNotif($current->getId(), $other_id, 'visit');
            return view('pages.home.profil', ['user' => $user, 'request' => $request, 'likeStatus' => $likeStatus]);
        } else {
            return view('errors.profil', ['login' => $login, 'request' => $request]);
        }
    }

    // Enregistre les informations supplementaires
    public function submitProfile(Request $request) {
        $session = Session::getInstance();
        $inputs = $request->all();
        $errorHandler = new ErrorHandler;
        $validator = new Validator($errorHandler);
        if (!isset($inputs['anniversaire']) ||
            !isset($inputs['anniversaire']['jour']) ||
            !isset($inputs['anniversaire']['mois']) ||
            !isset($inputs['anniversaire']['annee']))
            $validator->errors()->addError('date invalide', 'anniversaire');
        $checkInputs = Tool::checkInputs($inputs, [
            'sexe',
            'recherche',
            'anniversaire',
            'presentation',
            'interets',
            'adresse'
        ]);
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
                'required' => true,
                'maxlength' => 500
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
                'request' => $request,
                'result' => "[]",
                'currUser' => "[]",
                'search' => false,
                'mmr' => 0
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
        $errorHandler = new ErrorHandler;
        $validator = new Validator($errorHandler);
        $inputs = $request->all();
        if (!isset($inputs['anniversaire']) ||
            !isset($inputs['anniversaire']['jour']) ||
            !isset($inputs['anniversaire']['mois']) ||
            !isset($inputs['anniversaire']['annee']))
            $validator->errors()->addError('date invalide', 'anniversaire');
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
                'required' => true,
                'maxlength' => 500
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
            $errorHandler->addError("fichier invalide", "fichier");
            $ret = true;
        } elseif ($file == null || !$file->isValid()) {
            $errorHandler->addError($request->file('picture')->getErrorMessage()
                            , "fichier");
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
        if (isset($inputs['photoNo'])) {
            if (Tool::checkInputs($inputs, ['photoNo'])){
                if ($file == null) {
                    $errorHandler->addError("fichier invalide", "fichier");
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
                'modPhotos' => $ret,
                'photoNo' => $inputs['photoNo']
            ]);
        }
    }

    public function blockUser(Request $request, $login) {
        $login = htmlentities($login);
        if (User::loginExists($login)) {
            $session = Session::getInstance();
            $user = User::getUser($session->getValue('id'));
            $blocked_id = User::getUserId($login);
            if (!$user->isBlocked($blocked_id) || $login == $session->getValue('login')){
                $user->block($blocked_id);
                return redirect()->route('home');
            } else {
                $user->unblock($blocked_id);
                return redirect()->route('profile', ['login' => $login]);
            }
        }
    }

    public function reportUser(Request $request, $login) {
        $login = htmlentities($login);
        $session = Session::getInstance();
        if (User::loginExists($login) && $login != $session->getValue('login')) {
            $email = "fifiblop@gmail.com";
            $subject = "MATCHA - REPORT";
            $message = "<html>
                        <body>
                        <h2>report d'un utilisateur<h2>
                        <p>l'utilisateur " . $login . " fait l'objet d'un signalement</p>
                        </body>
                        </html>";
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: camagru@yopmail.com' . "\r\n" .
            $headers .= 'Reply-To: camagru@yopmail.com' . "\r\n" .
            $headers .= 'X-Mailer: PHP/' . phpversion();
            mail($email, $subject, $message, $headers);
        }
        return redirect()->route('profile', ['login' => $login]);
    }
}