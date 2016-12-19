<?php

namespace App\Models;

class Sexe {
    private static $table_name = "sexe";

    static function getId($desc) {
        $ret = app('db')->select('SELECT id FROM '. self::$table_name .' WHERE description = :description', 
        ['description' => $desc]);
        if ($ret)
            return ($ret[0]->{'id'});
        return false;
    }

    static function getDesc($id) {
        $ret = app('db')->select('SELECT description FROM '. self::$table_name .' WHERE id = :id', 
        ['id' => $id]);
        if ($ret)
            return ($ret[0]->{'description'});
        return false;
    }
}