<?php

namespace App\Models;

class Photo {

    // Insere en base le chemin de l'avatar
   static function setUserAvatar($user_id, $path) {
        $ret = app('db')->update('UPDATE user SET avatar = :avatar WHERE id = :id',
        [
            'id' => $user_id,
            'avatar' => $path
        ]);
        return $ret;
   }

   // Renvoi le chemin de l'avatar d'un utilisateur
   static function getUserAvatar($user_id) {
        $ret = app('db')->select('SELECT avatar FROM user WHERE id = :id',
        ['id' => $user_id]);
        if ($ret)
            return $ret[0]->{'avatar'};
        return false;
   }

   static function setUserPhoto($user_id, $path, $numPhoto) {
        self::deleteUserPhoto($user_id, $path, $numPhoto);
        $ret = app('db')->insert('INSERT INTO user_photos (user_id, src, num) VALUES (:user_id, :src, :num)',
        [
            'user_id' => $user_id,
            'src' => $path,
            'num' => $numPhoto
        ]);
   }

   static function deleteUserPhoto($user_id, $path, $numPhoto) {
        if (file_exists($path))
            unlink($path);
        $ret = app('db')->delete('DELETE FROM user_photos WHERE user_id = :user_id AND num = :num',
        [
            'user_id' => $user_id,
            'num' => $numPhoto
        ]);
        if ($ret)
            return true;
        return false;
   }

   static function getUserPhotos($user_id) {
        $ret = app('db')->select('SELECT * FROM user_photos WHERE user_id = :user_id',
        [
            'user_id' => $user_id
        ]);
        $array = array();
        foreach($ret as $item)
            $array[$item->{'num'}]['src'] = $item->{'src'};
        $ret = array();
        for($i = 0; $i < 4; $i++) {
            if (isset($array[$i + 1]))
                $ret[$i]['src'] = $array[$i + 1]['src'];
            else
                $ret[$i]['src'] = "";
        }
        if ($ret)
            return $ret;
        return false;
   }
}