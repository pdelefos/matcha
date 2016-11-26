<?php

namespace App\Classes;

class ErrorHandler {
    protected $errors = [];

    // Ajoute une erreur ( et une clé optionnelle ) 
    public function addError($error, $key = null) {
        if ($key) {
            $this->errors[$key][] = $error;
        }
        else {
            $this->errors[] = $error;
        }
    }

    // Récupere toutes les erreurs ou uniquement celles correspondant à la clé
    public function all($key = null) {
        return isset($this->errors[$key]) ? $this->errors[$key] : $this->errors;
    }

    // Renvoi false s'il n'y a aucune erreur sinon true
    public function hasErrors() {
        return count($this->all()) ? true : false;
    }

    // Renvoi la premiere erreur correspondant à la clé
    public function first($key) {
        return isset($this->all()[$key][0]) ? $this->all()[$key][0] : false;
    }
}