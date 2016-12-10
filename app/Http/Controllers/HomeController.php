<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\Validator;
use App\Classes\ErrorHandler;

class HomeController extends Controller
{

    public function __construct()
    {
        //
    }

    public function showHome() {
        return view('pages.home.home');
    }

    public function submitProfile(Request $request) {
        $inputs = $request->all();
        // var_dump($inputs);
        // die();
        $errorHandler = new ErrorHandler;
        $validator = new Validator($errorHandler);
        $validator->check($inputs, [
            'sexe' => [
                'required' => true
            ],
            'recherche' => [
                'required' => true
            ],
            'description' => [
                'required' => true
            ]
        ]);
        if ($validator->fails()) {
            return view('pages.home.home', ['prev_values' => $request, 'errorHandler' => $validator->errors()]);
        } else {

        }
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