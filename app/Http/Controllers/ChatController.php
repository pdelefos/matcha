<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller {
    
    public function __construct()
    {
        //
    }

    // Render la vue Chat
    public function showChat(Request $request) {
        return view('pages.home.chat',
        [
            'request' => $request
        ]);
    }
}