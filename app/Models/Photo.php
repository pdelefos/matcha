<?php

namespace App\Models;

class Photo {
   static function setUserAvatar($user_id, $path) {
        $ret = app('db')->update('UPDATE user SET avatar = :avatar WHERE id = :id',
        [
            'id' => $user_id,
            'avatar' => $path
        ]);
        return $ret;
   }

   static function getUserAvatar($user_id) {
        $ret = app('db')->select('SELECT avatar FROM user WHERE id = :id',
        ['id' => $user_id]);
        if ($ret)
            return $ret[0]->{'avatar'};
        return false;
   }

//    static function setUserPhoto($user_id, $path) {
//        $ret = app('db')->
//    }
}