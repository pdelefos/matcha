<?php

namespace App\Models;

class Online {

    private static $table_name = "online";

    static function goOnline($user_id) {
        $ret = app('db')->insert('INSERT INTO '. self::$table_name .' (user_id) VALUES (:user_id)', 
        [
            'user_id' => $user_id
        ]);
        if ($ret)
            return true;
        return false;
    }

    static function goOffline($user_id) {
        $ret = app('db')->delete('DELETE FROM '. self::$table_name .' WHERE user_id = :user_id',
        [
            'user_id' => $user_id
        ]);
        return $ret;
    }

    static function isOnline($user_id) {
        $ret = app('db')->select('SELECT * FROM '. self::$table_name .' WHERE user_id = :user_id', 
        [
            'user_id' => $user_id
        ]);
        if ($ret)
            return true;
        return false;
    }
}