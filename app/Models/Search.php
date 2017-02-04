<?php

namespace App\Models;

use App\Models\User;
use App\Models\Orientation;
use App\Models\Interest;
use App\Models\Sexe;
use App\Models\Score;
use App\Classes\Session;
use Illuminate\Support\Facades\DB as DB;

class Search {

    public static function search($user, $inputs) {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $blocked = self::getBlocked($user);
        $orientation = self::getSexPref($user);
        if (isset($inputs['age']) && isset($inputs['score']) &&
            isset($inputs['age']['min']) && isset($inputs['age']['max']) &&
            isset($inputs['score']['min']) && isset($inputs['score']['max'])) {
            $inputs['age'] = self::secureRange($inputs['age']);
            $inputs['score'] = self::secureRange($inputs['score']);
            $ret = DB::table('user')
                    ->join('user_interets', 'user.id', '=', 'user_interets.user_id')
                    ->join('interets', 'user_interets.interets_id', '=', 'interets.id')                
                    ->select('login', 'avatar', 'latitude', 'longitude', 'age', 'city')
                    ->whereIn('user.orientation_sexe_id', [Sexe::getId($user->getSexe()), Orientation::getId('indifferent')])
                    ->where('user.id', '<>', $user_id)
                    ->where('user.completed', '<>' , 0)
                    ->whereIn('user.sexe_id', $orientation)
                    ->when((isset($inputs['adresse']) && $inputs['adresse'] != ''), function ($query) use ($inputs) {
                        return $query->where('city', 'like', "%" . $inputs['adresse'] . "%");
                    })
                    ->when(isset($inputs['age']), function ($query) use ($inputs) {
                        return $query->whereBetween('user.age', [$inputs['age']['min'], $inputs['age']['max']]);
                    })
                    ->when($blocked, function ($query) use ($blocked) {
                        return $query->whereNotIn('user.id', $blocked);
                    })->distinct()->get();
            $i = 0;
            foreach($ret as $user) {
                $user->{'score'} = Score::getScore(User::getUserId($user->{'login'})); // implementation du calcul du score
                if (isset($inputs['score']) && 
                    ($user->{'score'} < (int) $inputs['score']['min'] ||
                    $user->{'score'} > (int) $inputs['score']['max']))
                    unset($ret[$i]);
                $user->{'interets'} = Interest::getUserInterest(User::getUserId($user->{'login'}));
                if (isset($inputs['interets']) && !self::searchInterets($user->{'interets'}, $inputs['interets']))
                    unset($ret[$i]);
                $i++;
            }
            $ret = array_values($ret);
            return json_encode($ret);
        }
    }

    private static function searchInterets($interetsUser, $interetsSearch) {
        foreach($interetsUser as $intUser) {
            foreach($interetsSearch as $intSearch) {
                if ($intUser == $intSearch)
                    return true;
            }
        }
        return false;
    }

    private static function secureRange($input){
        if(isset($input)) {
            if ($input['min'] < 0) $input['min'] = 0;
            if ($input['max'] > 100) $input['max'] = 100;
            return $input;
        }
        return $input;
    }

    public static function suggestions(User $user) {
        $session = Session::getInstance();
        $user_id = $session->getValue('id');
        $blocked = self::getBlocked($user);
        $orientation = self::getSexPref($user);
        $ret = DB::table('user')
                ->join('user_interets', 'user.id', '=', 'user_interets.user_id')
                ->join('interets', 'user_interets.interets_id', '=', 'interets.id')                
                ->select('login', 'avatar', 'latitude', 'longitude', 'age', 'city')
                ->whereIn('user.orientation_sexe_id', [Sexe::getId($user->getSexe()), Orientation::getId('indifferent')])
                ->where('user.id', '<>', $user_id)
                ->where('user.completed', '<>' , 0)
                ->whereIn('user.sexe_id', $orientation)
                ->when($blocked, function ($query) use ($blocked) {
                    return $query->whereNotIn('user.id', $blocked);
                })->distinct()->get();
        foreach($ret as $user) {
            $user->{'score'} = Score::getScore(User::getUserId($user->{'login'})); // implementation du calcul du score
            $user->{'interets'} = Interest::getUserInterest(User::getUserId($user->{'login'}));
        }
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
            return [(int) Orientation::getId('homme'), (int) Orientation::getId('femme'),
                    (int) Orientation::getId('indifferent')];
        return [(int) Orientation::getId($ret)];
    }
}