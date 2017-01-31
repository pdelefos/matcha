<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Likes;

class NotifController extends Controller {

    public function __construct()
    {
        //
    }

    // Render la vue Notification
    public function showNotif(Request $request) {
        return view('pages.home.notification',
        [
            'request' => $request
        ]);
    }

    public function isOnline(Request $request, $login) {
        $login = htmlentities($login);
        if (User::loginExists($login)) {
            $user = User::getUser(User::getUserId($login));
            if ($user->isOnline())
                return 1;
            else
                return $user->getLastVisit();
        }
        return 0;
    }

    public function likeUser(Request $request, $login) {
        $login = htmlentities($login);
        if (User::loginExists($login)) {
            // verifier qu'on le block pas
            // l'user courant a un avatar
            $other_id = User::getUserId($login);
            return (Likes::deleteLike($other_id));
        }
        return 0;
    }
}