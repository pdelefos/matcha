<?php

namespace App\Models;

use App\Models\User;
use App\Models\Orientation;
use Illuminate\Support\Facades\DB as DB;

class Search {
    public static function suggestions(User $user) {
        $blocked = self::getBlocked($user);
        $orientation = self::getSexPref($user);
        $ret = DB::table('user')
                ->join('user_interets', 'user.id', '=', 'user_interets.user_id')
                ->join('interets', 'user_interets.interets_id', '=', 'interets.id')                
                ->select('login', 'avatar', 'latitude', 'longitude', 'age')
                ->when($orientation, function ($query) use ($orientation) {
                    return $query->whereIn('user.sexe_id', $orientation);
                })
                ->when($blocked, function ($query) use ($blocked) {
                    return $query->whereNotIn('user.id', $blocked);
                })->distinct()->get();
        return json_encode($ret);
    }

    private static function getBlocked(User $user) {
        $bloqued = DB::table('block_table')
                    ->select('blocked_id')
                    ->where('asking_id', $user->getId())->get();
        if (!isset($bloqued[0]))
            return false;
        $ret = [];
        foreach($bloqued as $block)
            $ret[] = $block->blocked_id;
        return $ret;
    }

    private static function getSexPref(User $user) {
        $ret = $user->getOrientation();
        if (!$ret)
            return false;
        if ($ret == 'indifferent')
            return [Orientation::getId('homme'), Orientation::getId('femme'),
                    Orientation::getId('indifferent')];
        return [Orientation::getId($ret)];
    }
}