<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function get(Request $request) {
        return view('register', ['url' => $request->url()]);
    }

    public function post(Request $request) {
        $user = new User();
        $user->setLogin($request->input('login'));
        $user->setEmail($request->input('email'));
        $user->setNom($request->input('nom'));
        $user->setPrenom($request->input('prenom'));
        $user->save();
    }

    //
}
