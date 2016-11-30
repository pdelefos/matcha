<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\Validator;
use App\Classes\ErrorHandler;

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
        if ($validator->fails()) {
            return view('pages.register', ['prev_values' => $request, 'errorHandler' => $validator->errors()]);
        } else {
            $user = new User();     
            $user->setLogin($request->input('login'));
            $user->setEmail($request->input('email'));
            $user->setNom($request->input('nom'));
            $user->setPrenom($request->input('prenom'));
            $user->setPassword(hash("whirlpool", $request->input('password')));
            $user->register();
        }
    }

    // Render la page de connexion
    public function showConnexion() {
        return view('pages.connexion');
    }
}
