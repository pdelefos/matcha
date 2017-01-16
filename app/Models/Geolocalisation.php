<?php 

namespace App\Models;

class Geolocalisation {

    private static $apiKey = "AIzaSyCiwhivWRC5isZuX7Oc5bxBIIn2h3pzPOs"; 

    // Renvoi la ville correspondant a la latitude, longitude
    public static function getCityFromLatLng($lat, $lng) {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . "," . $lng . "&key=" . self::$apiKey;
      
        $obj = self::getJsonCurl($url);

        if ($obj->{'status'} == "ZERO_RESULTS")
            return false;
        return $obj->{'results'}[0]->{'address_components'}[2]->{'long_name'};        
    }

    // Renvoi la latitude, longitude depuis une adresse
    public static function getLatLngFromAddress($address) {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . self::$apiKey;

        $obj = self::getJsonCurl($url);

        if ($obj->{'status'} == "ZERO_RESULTS")
            return false;
        $ret['lat'] = $obj->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
        $ret['lng'] = $obj->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}; 
        return $ret;
    }

    // Renvoi un Json resultant de l'url
    private static function getJsonCurl(String $url) {
        ini_set("allow_url_fopen", 1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }
}