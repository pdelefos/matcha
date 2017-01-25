<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        if (User::loginExists($login))
            $user = User::getUser(User::getUserId($login));
            if ($user->isOnline())
                return 1;
            else
                return $user->getLastVisit();
        return 0;
    }
}