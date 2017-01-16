<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\Session;
use App\Models\Interest;


class HomeController extends Controller {

    public function __construct()
    {
        //
    }

    // Render la vue HOME
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
    }
}