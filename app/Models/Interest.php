<?php

namespace App\Models;

class Interest {
    
    // Renvoi l'id correspondant a un interet
    static function getId($interet) {
        $ret = app('db')->select('SELECT id FROM interets WHERE description = :description',
        ['description' => $interet]);
        if ($ret)
            return $ret[0]->{'id'};
        return false;
    }

    // Ajoute un interet dans la base et renvoi l'id
    static function insertInterest($interest) {
        $ret = app('db')->insert('INSERT INTO interets (description) VALUES (:description)',
                ['description' => $interest]);
        if ($ret)
            return Self::getId($interest);
        return false;
    }

    // Ajoute un interet et un utilisateur dans la table user_interets
    static function setUserInterest($user_id, $interest_id) {
        $ret = app('db')->insert('INSERT INTO user_interets (user_id, interets_id) VALUES (:user_id, :interets_id)',
        [
            'user_id' => $user_id,
            'interets_id' => $interest_id
        ]);
        return $ret;
    }

    // Ajoute un tableau d'interets en base seulement si l'interet n'existe pas
    // Ajoute ensuite les interets a un utilisateur
    static function saveInterests($user_id, array $interests) {
        Self::deleteInterests($user_id);
        foreach ($interests as $interest) {
            $id_interest = Self::getId($interest);
            if (!$id_interest)
                $id_interest = Self::insertInterest($interest);
            Self::setUserInterest($user_id, $id_interest);    
        }
    }

    // Renvoi une chaine avec tout les interets en base
    static function getInterests() {
        $ret = app('db')->select('SELECT description FROM interets');
        $interests = array();
        foreach ($ret as $value)
            $interests[] = $value->{'description'};
        return implode(",", $interests);
    }

    // Supprime tout les interets d'un utilisateur
    static function deleteInterests($user_id) {
        $ret = app('db')->delete('DELETE FROM user_interets WHERE user_id = :user_id',
        ['user_id' => $user_id]);
        return $ret;
    }
}