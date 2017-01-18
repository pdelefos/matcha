<?php

namespace App\Models;

class Tool {

    public static function checkInputs(array $inputs, array $inputsNames) {
        if ($inputs == null || $inputsNames == null)
            return false;
        foreach($inputsNames as $name){
            if (!isset($inputs[$name]))
                return false;
        }
        return true;
    }
    
}