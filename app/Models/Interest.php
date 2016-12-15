<?php

namespace App\Models;

class Interest {
    
    static function getId($interet) {
        $ret = app('db')->select('SELECT id FROM interets WHERE description = :description',
        ['description' => $interet]);
        if ($ret)
            return $ret[0]->{'id'};
        return false;
    }

    static function insertInterest($interest) {
        $ret = app('db')->insert('INSERT INTO interets (description) VALUES (:description)',
                ['description' => $interest]);
        if ($ret)
            return Self::getId($interest);
        return false;
    }

    static function setUserInterest($user_id, $interest_id) {
        $ret = app('db')->insert('INSERT INTO user_interets (user_id, interets_id) VALUES (:user_id, :interets_id)',
        [
            'user_id' => $user_id,
            'interets_id' => $interest_id
        ]);
        return $ret;
    }

    static function saveInterests($user_id, array $interests) {
        foreach ($interests as $interest) {
            $id_interest = Self::getId($interest);
            if (!$id_interest)
                $id_interest = Self::insertInterest($interest);
            Self::setUserInterest($user_id, $id_interest);    
        }
    }

    static function getInterests() {
        $ret = app('db')->select('SELECT description FROM interets');
        $interests = array();
        foreach ($ret as $value)
            $interests[] = $value->{'description'};
        return implode(",", $interests);
        // return json_encode($interests);
    }
}