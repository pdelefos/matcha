<?php

namespace App\Models;

use App\Models\User;
use App\Classes\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as DB;

class Notification {

    private static $table_name = "notification";

    private static function getId($desc) {
        $ret = app('db')->select('SELECT id FROM notification_type WHERE description = :description', 
        ['description' => $desc]);
        if ($ret)
            return ($ret[0]->{'id'});
        return false;
    }

    static function setNotif($user_id, $other_id, $type_notif) {
        $ret = DB::table(self::$table_name)->insert([
            'user_id' => $user_id,
            'other_id' => $other_id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'notification_id' => self::getId($type_notif)
        ]);
        if ($ret)
            return true;
        return false;
    }

    // static function getNbNotif($user_id) {

    // }

    public static function getCurrentNotifs() {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $blocked = self::getBlocked($user_id);
        $ret = DB::table(self::$table_name)
                    ->join('user', 'user.id', '=', 'notification.user_id')
                    ->join('notification_type', 'notification_type.id', '=', 'notification.notification_id')
                    ->select('user_id', 'other_id', 'user.login', 'seen', 'notification_type.description')
                    ->where('other_id', '=', $user_id)
                    ->whereNotIn('user_id', $blocked)
                    ->latest(25)
                    ->orderBy('notification.created_at', 'desc')
                    ->get();
        if ($ret)
            return $ret;
        return [];
    }

    public static function setCurrentAsSeen() {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $blocked = self::getBlocked($user_id);
        $ret = DB::table(self::$table_name)
                    ->where('other_id', '=', $user_id)
                    ->whereNotIn('user_id', $blocked)
                    ->update(['seen' => 1]);
        if ($ret)
            return true;
        return false;
    }

    private static function getBlocked($id) {
        $bloqued = DB::table('block_table')
                    ->select('blocked_id')
                    ->where('asking_id', $id)->get();
        $ret = [];
        if (!isset($bloqued[0]))
            return $ret;
        foreach($bloqued as $block)
            $ret[] = $block->blocked_id;
        return $ret;
    }
}