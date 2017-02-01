<?php

namespace App\Models;

use App\Models\User;
use App\Classes\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as DB;

class Visit {
    private static $table_name = "visit";

    public static function visit($id) {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $ret = DB::table(self::$table_name)->insert([
            'user_id' => $user_id,
            'other_id' => $id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        if ($ret)
            return true;
        return false;
    }

    public static function getCurrentVisits() {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $blocked = self::getBlocked($user_id);
        $ret = DB::table(self::$table_name)
                    ->join('user', 'user.id', '=', 'visit.user_id')
                    ->select('user_id', 'other_id', 'user.login', 'seen')
                    ->where('other_id', '=', $user_id)
                    ->whereNotIn('user_id', $blocked)
                    ->limit(25)
                    ->orderBy('visit.created_at', 'desc')
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

    public static function getNbVisit($id) {
        $blocked = self::getBlocked($id);
        $ret = DB::table(self::$table_name)
                    ->where('other_id', '=', $id)
                    ->whereNotIn('user_id', $blocked)
                    ->count();
        if ($ret)
            return $ret;
        return 0;
    }
}