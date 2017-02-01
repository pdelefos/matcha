<?php

namespace App\Models;

use App\Models\User;
use App\Classes\Session;
use Illuminate\Support\Facades\DB as DB;

class Likes {

    private static $table_name = "like";

    public static function like($id) {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $ret = DB::table(self::$table_name)->insert([
            'user_id' => $user_id,
            'other_id' => $id
        ]);
        if ($ret)
            return true;
        return false;
    }

    public static function deleteLike($id) {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $ret = DB::table(self::$table_name)
            ->where('user_id', '=', $user_id)
            ->where('other_id', '=', $id)
            ->delete();
        if ($ret)
            return true;
        return false;
    }

    public static function isLike($id) {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $ret = DB::table(self::$table_name)->select('id')
                ->where('user_id', "=", $user_id)
                ->where('other_id', "=", $id)
                ->get();
        if (!empty($ret))
            return true;
        return false;
    }

    public static function isUserLike($user1_id, $user2_id) {
        $ret = DB::table(self::$table_name)->select('id')
                ->where('user_id', "=", $user1_id)
                ->where('other_id', "=", $user2_id)
                ->get();
        if (!empty($ret))
            return true;
        return false;
    }

    public static function match($id) {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $ret = DB::table('match')->insert([
            'user_id' => $user_id,
            'other_id' => $id
        ]);
        if ($ret)
            return true;
        return false;
    }

    public static function deleteMatch($id) {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $ret = DB::table('match')
            ->whereIn('user_id', [$user_id, $id])
            ->whereIn('other_id', [$user_id, $id])
            ->delete();
        if ($ret)
            return true;
        return false;
    }

    public static function isMatch($id) {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $ret = DB::table('match')->select('id')
                ->whereIn('user_id', [$user_id, $id])
                ->whereIn('other_id', [$user_id, $id])
                ->get();
        if (!empty($ret))
            return true;
        return false;
    }

    public static function getStatus($id) {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        if (!self::isMatch($id)) {
            if (!self::isUserLike($user_id, $id) && 
                !self::isUserLike($id, $user_id))
                return 'nothing';
            if (self::isUserLike($user_id, $id) && 
                !self::isUserLike($id, $user_id))
                return 'like';
            if (!self::isUserLike($user_id, $id) && 
                self::isUserLike($id, $user_id))
                return 'likeback';
        } else {
            return 'match';
        }
    }

    public static function getNbLike($id) {
        $blocked = self::getBlocked($id);
        $ret = DB::table(self::$table_name)
                    ->where('other_id', '=', $id)
                    ->whereNotIn('user_id', $blocked)
                    ->count();
        if ($ret)
            return $ret;
        return 0;
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