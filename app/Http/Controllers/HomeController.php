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
        $interests = Interest::getInterests();
        if (!$user->getCompleted()) {
            return view('pages.home.home',
            [
                'interests' => $interests, 
                'user' => $user,
                'request' => $request,
                'currUser' => "[]",
                'result' => "[]",
                'search' => false
            ]);
        }
        $currUser= self::getJsCurrentUser($user);
        $result = Search::suggestions($user);
        return view('pages.home.home',
        [
            'interests' => $interests, 
            'user' => $user,
            'currUser' => $currUser,
            'request' => $request,
            'result' => $result,
            'search' => false
        ]);
    }

    public function showSearch(Request $request) {
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
            'request' => $request,
            'currUser' => $currUser,
            'result' => $result,
            'search' => true
        ]);
    }

    public function submitSearch(Request $request) {
        // var_dump($request->all());
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
            'request' => $request,
            'currUser' => $currUser,
            'result' => $result,
            'search' => false
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