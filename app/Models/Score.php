<?php

namespace App\Models;

use App\Models\User;
use App\Models\Visit;
use App\Models\Likes;
use App\Classes\Session;
use Illuminate\Support\Facades\DB as DB;

class Score {
    
    public static function getScore($id) {
        $nbVisit = Visit::getNbVisit($id);
        $nbLike = Likes::getNbLike($id);
        $score = (($nbVisit * 4) + ($nbLike * 6)) / 10;
        return (int) round($score);
    }
}