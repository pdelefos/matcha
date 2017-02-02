<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\Session;
use App\Models\Likes;
use App\Models\Visit;
use App\Models\Notification;

class NotifController extends Controller {

    public function __construct()
    {
        //
    }

    // Render la vue Notification
    public function showNotif(Request $request) {
        $visits = Visit::getCurrentVisits();
        Visit::setCurrentAsSeen();
        $notifs = Notification::getCurrentNotifs();
        Notification::setCurrentAsSeen();
        return view('pages.home.notification',
        [
            'request' => $request,
            'visits' => $visits,
            'notifs' => $notifs
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
        $session = Session::getInstance();
        $user = User::getUser($session->getValue('id'));
        $login = htmlentities($login);
        $user_id = $user->getId();
        $other_id = User::getUserId($login);
        $response = [];
        if (User::loginExists($login)) {
            if ($user_id == $other_id) {
                return $response['error'] = "ownlike";
            } else if ($user->isBlocked($other_id)) {
                $response['error'] = "blocked";
                return $response;
            } else if (empty($user->getAvatar())) {
                return $response['error'] = "nopicture";
            } else {
                $other_id = User::getUserId($login);
                // si pas de match
                if (!Likes::isMatch($other_id)) {
                    // si pas de like et pas de like-back
                    if (!Likes::isLike($other_id) && 
                        !Likes::isUserLike($other_id, $user_id)) {
                        Likes::like($other_id);
                        Notification::setNotif($user_id, $other_id, 'like');
                        return $response['success'] = "like";
                        // si like et pas de like-back
                    } else if (Likes::isLike($other_id) && 
                                !Likes::isUserLike($other_id, $user_id)) {
                        Likes::deleteLike($other_id);
                        Notification::setNotif($user_id, $other_id, 'unlike');
                        return $response['success'] = "unlike";
                        // si pas de like et like-back
                    } else if (!Likes::isLike($other_id) && 
                                Likes::isUserLike($other_id, $user_id)) {
                        Likes::like($other_id);
                        Likes::match($other_id);
                        Notification::setNotif($user_id, $other_id, 'match');                        
                        return $response['success'] = "match";
                    }
                // si match
                } else {
                    Likes::deleteMatch($other_id);
                    Likes::deleteLike($other_id);
                    Notification::setNotif($user_id, $other_id, 'unlike');                    
                    return $response['success'] = "unmatch";
                }
            }
        } else {
            return $response['error'] = "cette utilisateur n'existe pas";
        }
    }

    public function getNotif(Request $request) {
        return Notification::getNbNotif();
    }
}