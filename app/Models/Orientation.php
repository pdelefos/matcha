<?php

namespace App\Models;

class Orientation {

    private static $table_name = "orientation_sexe";

    // Renvoi l'ID correspondant a une orientation
    static function getId($desc) {
        $ret = app('db')->select('SELECT id FROM '. self::$table_name .' WHERE description = :description', 
        ['description' => $desc]);
        if ($ret)
            return ($ret[0]->{'id'});
        return false;
    }

    // Renvoi l'orientation correspondant a une description
    static function getDesc($id) {
        $ret = app('db')->select('SELECT description FROM '. self::$table_name .' WHERE id = :id', 
        ['id' => $id]);
        if ($ret)
            return ($ret[0]->{'description'});
        return false;
    }
}