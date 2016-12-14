<?php

namespace App\Models;

class Sexe {
    static function getId($sexe) {
        $ret = app('db')->select('SELECT id FROM sexe WHERE description = :description', 
        ['description' => $sexe]);
        if ($ret)
            return ($ret[0]->{'id'});
        return false;
    }
}