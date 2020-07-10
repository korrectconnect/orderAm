<?php

namespace App\Services;

use GuzzleHttp\Client;

class GoogleMaps
{
    public static function getDistance($user_origin_lat, $user_origin_long, $vendor_lat, $vendor_long)
    {
        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins='.urlencode($user_origin_lat.','.$user_origin_long).'&destinations='.urlencode($vendor_lat.','.$vendor_long).'&key='.env('GOOGLE_MAPS_KEY');

        $client = new Client();

        $response = $client->get($url)->getBody();

        $decoded_response = \json_decode($response);

        $details['distance'] = null;
        $details['duration'] = null;

        if(!empty($decoded_response) && isset($decoded_response->rows[0])){
            $details['distance'] = $decoded_response->rows[0]->elements[0]->distance->text;
            $details['duration'] = $decoded_response->rows[0]->elements[0]->duration->text;
        }

        return $details;
    }

    public static function getAddress($address)
    {
        $url = $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&key='.env( 'GOOGLE_MAPS_KEY' );
        
        $client = new Client();

        $response = $client->get($url)->getBody();
        $decoded_response = json_decode($response);

        $coordinates['lat'] = null;
        $coordinates['long'] = null;

        if(!empty($decoded_response) && isset($decoded_response->results[0])){
            $coordinates['lat'] = $decoded_response->results[0]->geometry->location->lat;
            $coordinates['long'] = $decoded_response->results[0]->geometry->location->lng;
        }

        return $coordinates;
    }
}