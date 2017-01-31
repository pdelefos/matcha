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
            return 'true';
        return 'false';
    }

    public static function deleteLike($id) {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $ret = DB::table(self::$table_name)
            ->where('user_id', '=', $user_id)
            ->where('other_id', '=', $id)
            ->delete();
        if ($ret)
            return 'true';
        return 'false';
    }

    public static function match($id) {

    }

    public static function deleteMatch($id) {
        
    }

    public static function isMatch($id) {
        
    }
}