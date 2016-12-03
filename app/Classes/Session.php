<?php

namespace App\Classes;

class Session {

    private static $instance;

    // Crée une instance de session si n'existe pas 
    // et la renvoi
    public static function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new Session();
        return self::$instance;
    }

    // Démarre la session
    private function __construct() {
        session_start();
    }

    // Récupère la valeur d'une clé ou false
    public function getValue($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
    }

    // Enregistre une valeur et une clé dans la session
    public function setValue($key, $value) {
        $_SESSION[$key] = $value;
    }

    // Récupère un tableau de clé et de valeurs
    // Les enregistre dans la session
    public function login($logValues = array()) {
        $_SESSION['authentication_ip'] = $_SERVER['REMOTE_ADDR'];
        foreach($logValues as $key => $value)
            $_SESSION[$key] = $value;
    }

    // Détruit la session
    public function logout() {
        session_unset();
        session_destroy();
    }
}