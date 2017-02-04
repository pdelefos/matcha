<?php

namespace App\Models;

use App\Models\User;
use App\Models\Like;
use App\Classes\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as DB;

class Message {
    private static $table_name = "conversation";

    static function sendMessage($from_id, $to_id, $msg) {
        $ret = DB::table(self::$table_name)
            ->insert([
                'user_id' => $from_id,
                'other_id' => $to_id,
                'message' => $msg,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        if ($ret)
            return true;
        return false;
    }

    static function getConv($from_id, $to_id) {
        $blocked = self::getBlocked($from_id);
        $ret = DB::table(self::$table_name)
            ->select('user_id', 'other_id' , 'message')
            ->whereIn('user_id', [$from_id, $to_id])
            ->whereIn('other_id', [$from_id, $to_id])
            ->whereNotIn('other_id', $blocked)
            ->get();
        $array = [];
        foreach($ret as $message) {
            $msg = [];
            if ($message->{'user_id'} == $from_id)
                $msg['sender'] = 'expe';
            else
                $msg['sender'] = 'dest';
            $msg['msg'] = $message->{'message'};
            $array[] = $msg;
        }
        return $array;
    }

    static function setConvAsSeen($from_id, $to_id) {
        $blocked = self::getBlocked($from_id);
        $ret = DB::table(self::$table_name)
                    ->where('user_id', $from_id)
                    ->where('other_id', $to_id)
                    ->whereNotIn('other_id', $blocked)
                    ->update(['seen' => 1]);
        $ret = DB::table(self::$table_name)
                    ->where('user_id', $to_id)
                    ->where('other_id', $from_id)
                    ->whereNotIn('user_id', $blocked)
                    ->update(['seen_other' => 1]);
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

    public static function getNbVisit($from_id) {
        $blocked = self::getBlocked($from_id);
        $ret = DB::table(self::$table_name)
                    ->where('user_id', $from_id)
                    ->whereNotIn('other_id', $blocked)
                    ->where('seen', '=', 0)
                    ->count();
        $ret1 = DB::table(self::$table_name)
                    ->where('other_id', $from_id)
                    ->whereNotIn('user_id', $blocked)
                    ->where('seen_other', '=', 0)
                    ->count();
        return $ret + $ret1;
    }
}