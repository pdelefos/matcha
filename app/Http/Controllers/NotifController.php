<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifController extends Controller {

    public function __construct()
    {
        //
    }

    // Render la vue Notification
    public function showNotif(Request $request) {
        return view('pages.home.notification',
        [
            'request' => $request
        ]);
    }
}