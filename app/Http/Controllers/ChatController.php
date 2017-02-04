<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Session;
use App\Models\User;
use App\Models\Likes;
use App\Models\Message;

class ChatController extends Controller {
    
    public function __construct()
    {
        //
    }

    // Render la vue Chat
    public function showChat(Request $request) {
        $session = Session::getInstance();
        $usersConv = Likes::getAllMatches($session->getValue('id'));
        return view('pages.home.chat',
        [
            'request' => $request,
            'usersConv' => $usersConv
        ]);
    }

    public function getConvWith(Request $request, $login) {
        $login = htmlentities($login);
        if (User::loginExists($login) && Likes::isMatch(User::getUserId($login))) {
            $session = Session::getInstance();
            $user_id = $session->getValue('id');
            $other_id = User::getUserId($login);
            $ret = Message::getConv($user_id, $other_id);
            Message::setConvAsSeen($user_id, $other_id);
            return json_encode($ret);
        } else {
            $ret['error'] = 'utilisateur n\'existe pas ou n\'est pas matché';
            return json_encode($ret);
        }
    }

    public function sendMessage(Request $request) {
        $session = Session::getInstance();
        $currentUser = User::getUser($session->getValue('id'));
        $inputs = $request->all();
        if (isset($inputs['dest']))
            $login = $inputs['dest'];
        else
            $login = "";
        $login = htmlentities($login);
        if (User::loginExists($login) && Likes::isMatch(User::getUserId($login))
            && !$currentUser->isBlocked(User::getUserId($login))) {
            if (isset($inputs['msg']) && strlen($inputs['msg']) <= 500 || !empty($inputs['msg']))
                Message::sendMessage($currentUser->getId(), User::getUserId($login), $inputs['msg']);
        }
    }

    public function getNotif(Request $request) {
        $session = Session::getInstance();
        return Message::getNbVisit($session->getValue('id'));
    }
}