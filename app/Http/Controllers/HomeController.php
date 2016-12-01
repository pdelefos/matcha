<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        //
    }

    public function showHome() {
        return view('pages.home.home');
    }

    public function showProfile() {
        return view('pages.home.profile');
    }

    public function showNotif() {
        return view('pages.home.notification');
    }

    public function showChat() {
        return view('pages.home.chat');
    }
}