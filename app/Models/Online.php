<?php

namespace App\Models;

class Online {

    private static $table_name = "notification";

    static function getId($desc) {
        $ret = app('db')->select('SELECT id FROM notification_type WHERE description = :description', 
        ['description' => $desc]);
        if ($ret)
            return ($ret[0]->{'id'});
        return false;
    }

    static function goOnline($user_id) {
        $ret = app('db')->insert('INSERT INTO '. self::$table_name .' (user_id, notification_id) VALUES (:user_id, :notification_id)', 
        [
            'user_id' => $user_id,
            'notification_id' => self::getId('online')
        ]);
        if ($ret)
            return true;
        return false;
    }

    static function goOffline($user_id) {
        $ret = app('db')->delete('DELETE FROM '. self::$table_name .' WHERE user_id = :user_id AND notification_id = :notification_id',
        [
            'user_id' => $user_id,
            'notification_id' => self::getId('online')
        ]);
        return $ret;
    }

    static function isOnline($user_id) {
        $ret = app('db')->select('SELECT * FROM '. self::$table_name .' WHERE user_id = :user_id AND notification_id = :notification_id', 
        [
            'user_id' => $user_id,
            'notification_id' => self::getId('online')
        ]);
        if ($ret)
            return true;
        return false;
    }
}