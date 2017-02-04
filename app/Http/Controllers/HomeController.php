<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\Session;
use App\Models\Interest;
use App\Models\Search;
use App\Models\Tool;
use App\Classes\Validator;
use App\Classes\ErrorHandler;

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
                'search' => false,
                'mmr' => 1
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
            'search' => false,
            'mmr' => 1
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
            'search' => true,
            'mmr' => 0
        ]);
    }

    public function submitSearch(Request $request) {
        $inputs = $request->all();
        if (!isset($inputs['age']) && !isset($inputs['score']) &&
            !isset($inputs['adresse']) && !isset($inputs['interets']))
            return redirect()->route('recherche');
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $user = User::getUser($user_id);
        $currUser= self::getJsCurrentUser($user);
        $interests = Interest::getInterests();
        $result = Search::search($user, $inputs);
                return view('pages.home.home',
        [
            'interests' => $interests, 
            'user' => $user,
            'currUser' => $currUser,
            'request' => $request,
            'result' => $result,
            'search' => false,
            'mmr' => 0
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