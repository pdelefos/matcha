<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\Session;
use App\Models\Interest;
use App\Models\Search;

class HomeController extends Controller {

    public function __construct()
    {
        //
    }

    // Render la vue HOME
    public function showHome(Request $request) {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $user = User::getUser($user_id);
        $currUser= self::getJsCurrentUser($user);
        $interests = Interest::getInterests();
        $result = Search::suggestions($user);
        return view('pages.home.home',
        [
            'interests' => $interests, 
            'user' => $user,
            'currUser' => $currUser,
            'request' => $request,
            'result' => $result
        ]);
    }

    private function getJsCurrentUser(User $user) {
        $currUser['login'] = $user->getLogin();
        $currUser['latitude'] = $user->getLatitude();
        $currUser['longitude'] = $user->getLongitude();
        $currUser['interets'] = $user->getInterests();
        return json_encode($currUser);
    }
}