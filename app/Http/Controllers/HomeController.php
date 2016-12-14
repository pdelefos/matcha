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
            'description' => [
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
            return view('pages.home.home', ['prev_values' => $request, 'errorHandler' => $validator->errors()]);
        } else {
            var_dump($inputs);
            die();
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