<?php

namespace App\Models;

class Orientation {
    static function getId($orientation) {
        $ret = app('db')->select('SELECT id FROM orientation_sexe WHERE description = :description', 
        ['description' => $orientation]);
        if ($ret)
            return ($ret[0]->{'id'});
        return false;
    }
}