<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\Validator;
use App\Classes\ErrorHandler;
use App\Classes\Session;
use App\Models\Tool;

class AuthController extends Controller
{

    public function __construct()
    {
        //
    }

    
    // Render la page d'inscription
    public function showRegister() {
        return view('pages.register');
    }

    //Validation et insertion des données en base
    public function submitRegister(Request $request) {
        $inputs = $request->all();
        $checkInputs = Tool::checkInputs($inputs, [
            'nom',
            'prenom',
            'email',
            'login',
            'password'
        ]);
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
                'uniqueEmail' => true
            ],
            'login' => [
                'required' => true,
                'alnum' => true,
                'minlength' => 5,
                'maxlength' => 150,
                'uniqueLogin' => true
            ],
            'password' => [
                'required' => true,
                'minlength' => 5,
                'maxlength' => 150,
                'password' => true
            ]
        ]);
        if ($validator->fails() || !$checkInputs) {
            return view('pages.register', ['prev_values' => $request, 'errorHandler' => $validator->errors()]);
        } else {
            $user = new User();     
            $user->setLogin($request->input('login'));
            $user->setEmail($request->input('email'));
            $user->setNom($request->input('nom'));
            $user->setPrenom($request->input('prenom'));
            $user->setPassword(hash("whirlpool", $request->input('password')));
            $user_id = $user->register();
            $user->setId($user_id);
            $user->goOnline();
            $session = Session::getInstance();
            $session->login(['id' => $user_id, 'login' => $request->input('login')]);
            return redirect()->route('home');
        }
    }

    // Render la page de connexion
    public function showConnexion() {
        return view('pages.connexion');
    }

    public function submitConnexion(Request $request) {
        $inputs = $request->all();
        $checkInputs = Tool::checkInputs($inputs, [
            'login',
            'password'
        ]);
        $errorHandler = new ErrorHandler;
        $validator = new Validator($errorHandler);
        $validator->check($inputs, [
            'login' => [
                'required' => true,
                'alnum' => true,
                'minlength' => 5,
                'maxlength' => 150
            ],
            'password' => [
                'required' => true,
                'minlength' => 5,
                'maxlength' => 150,
                'password' => true
            ]
        ]);
        if ($validator->fails() || !$checkInputs)
            return view('pages.connexion', ['prev_values' => $request, 'errorHandler' => $validator->errors()]);
        $user = new User();
        $user->setLogin($request->input('login'));
        $user->setPassword(hash("whirlpool", $request->input('password')));
        if (!$user_id = $user->login()){
            $validator->errors()->addError('Combinaison login/mot de passe invalide', 'login');
            return view('pages.connexion', ['prev_values' => $request, 'errorHandler' => $validator->errors()]);
        }
        $session = Session::getInstance();
        $session->login(['id' => $user_id, 'login' => $request->input('login')]);
        $user = User::getUser($user_id);
        $user->goOnline();
        return redirect()->route('home');
    }

    public function submitRecover(Request $request) {
        $inputs = $request->all();
        $checkInputs = Tool::checkInputs($inputs, ['email']);
        $errorHandler = new ErrorHandler;
        $validator = new Validator($errorHandler);
        $validator->check($inputs, [
            'email' => [
                'required' => true,
                'email' => true,
                'emailExist' => true
            ]
        ]);
        if ($validator->fails() || !$checkInputs)
            return view('pages.recover', ['prev_values' => $request, 'errorHandler' => $validator->errors()]);
    }

    // Render la page de récupération de mot de passe
    public function showRecover() {
        return view('pages.recover');
    }

    // deconnecte l'utilisateur courant et le renvoi au register
    public function logout() {
        $session = Session::getInstance();
        $user = User::getUser($session->getValue('id'));
        $user->goOffline();
        $session->logout();
        return redirect()->route('root');
    }
}
