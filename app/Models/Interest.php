<?php

namespace App\Models;

class Interest {

    private static $table_name = "interets";
    
    // Renvoi l'id correspondant a un interet
    public static function getId($interet) {
        $ret = app('db')->select('SELECT id FROM '. self::$table_name .' WHERE description = :description',
        ['description' => $interet]);
        if ($ret)
            return $ret[0]->{'id'};
        return false;
    }

    // Ajoute un interet dans la base et renvoi l'id
    public static function insertInterest($interest) {
        $ret = app('db')->insert('INSERT INTO '. self::$table_name .' (description) VALUES (:description)',
                ['description' => $interest]);
        if ($ret)
            return Self::getId($interest);
        return false;
    }

    // Ajoute un interet et un utilisateur dans la table user_interets
    public static function setUserInterest($user_id, $interest_id) {
        $ret = app('db')->insert('INSERT INTO user_interets (user_id, interets_id) VALUES (:user_id, :interets_id)',
        [
            'user_id' => $user_id,
            'interets_id' => $interest_id
        ]);
        return $ret;
    }

    // Renvoi le tableau d'interet d'un utilisateur
    public static function getUserInterest($user_id) {
        $ret = app('db')->select("SELECT description 
        FROM ". self::$table_name ." AS i, user AS u, user_interets AS ui 
        WHERE u.id = ui.user_id AND i.id = ui.interets_id AND u.id = :id",
        [
            'id' => $user_id
        ]);
        $interests = array();
        foreach ($ret as $value)
            $interests[] = $value->{'description'};
        return $interests;
    }

    // Ajoute un tableau d'interets en base seulement si l'interet n'existe pas
    // Ajoute ensuite les interets a un utilisateur
    public static function saveInterests($user_id, array $interests) {
        Self::deleteInterests($user_id);
        foreach ($interests as $interest) {
            $id_interest = Self::getId($interest);
            if (!$id_interest)
                $id_interest = Self::insertInterest($interest);
            Self::setUserInterest($user_id, $id_interest);    
        }
    }

    // Renvoi une chaine avec tout les interets en base
    public static function getInterests() {
        $ret = app('db')->select('SELECT description FROM '. self::$table_name);
        $interests = array();
        foreach ($ret as $value)
            $interests[] = $value->{'description'};
        return implode(",", $interests);
    }

    // Supprime tout les interets d'un utilisateur
    public static function deleteInterests($user_id) {
        $ret = app('db')->delete('DELETE FROM user_interets WHERE user_id = :user_id',
        ['user_id' => $user_id]);
        return $ret;
    }
}