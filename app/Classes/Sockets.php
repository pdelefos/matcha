<?php

namespace App\Classes;

class Socket {

    public static function socket() {
        if (!($sock = socket_create(AF_INET, SOCK_STREAM, 0))) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            die("socket ta mere: [$errorcode] $errormsg \n");
        }
        echo "socket created \n";
        if ()
    }
}

Socket::socket();