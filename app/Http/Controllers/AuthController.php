<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\Validator;
use App\Classes\ErrorHandler;

class AuthController extends Controller
{
    /*
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /*
     * Render la page d'inscription
     */
    public function showRegister(Request $request) {
        return view('pages.home', ['url' => $request->url()]);
    }

    /*
     * Validation et insertion des données en base
     */
    public function submitRegister(Request $request) {
        $array = $request->all();
        $errorHandler = new ErrorHandler;
        $validator = new Validator($errorHandler);
        $validator->check($array, [
            'nom' => [
                'required' => true,
                'maj' => true
            ],
            'prenom' => [
                'required' => true
            ],
            'email' => [
                'required' => true,
                'email' => true
            ],
            'login' => [
                'required' => true,
                'maxlength' => 20,
                'minlength' => 3,
                'maj' => true
            ],
            'password' => [
                'required' => true
            ]
        ]);
        if ($validator->fails())
            print_r($validator->errors());
        else {
            $user = new User();     
            $user->setLogin($request->input('login'));
            $user->setEmail($request->input('email'));
            $user->setNom($request->input('nom'));
            $user->setPrenom($request->input('prenom'));
            $user->setPassword($request->input('password'));
            $user->save();
        }
    }

    /*
     * Render la page de connexion
     */
    public function showConnection(Request $request) {
        return view('pages.connection', ['url' => $request->url()]);
    }
}
