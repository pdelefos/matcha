<?php

namespace App\Http\Middleware;

use Closure;
use App\Classes\Session;
use App\Models\User;

class AuthMiddleware
{
    // verifie que l'utilisateur et connecté sinon le renvoi au register
    public function handle($request, Closure $next)
    {
        $session = Session::getInstance();
        if(empty($session->getValue('login')))
            return redirect()->route('root');
        // if (!User::getUserCompleted(User::getId($session->getValue('login'))))
        //     return redirect()->route('home');
        return $next($request);
    }
}