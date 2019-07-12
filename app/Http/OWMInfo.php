<?php

namespace App\Http;

use GuzzleHttp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OWMInfo {


    function isValidZipCode($zipCode) {
        return (preg_match('/^[0-9]{5}(-[0-9]{4})?$/', $zipCode)) ? true : false;
    }

    public function getWindInfo($zipcode)
    {
        if($this->isValidZipCode($zipcode)){
 //           $minutes = 15;
 //           $info = Cache::remember('info', $minutes, function () use ($zipcode){
 //               });
 //           return $info;
            $apiKey = config("owm.api_key");
            $url = "api.openweathermap.org/data/2.5/weather?zip=${zipcode}&appid=${apiKey}";
            Log::info($url);
            $client = new \GuzzleHttp\Client();
            $res = $client->get($url);

            if ($res->getStatusCode() == 200) {
                $jsonArray = json_decode($res->getBody());
            }else{
                return Response::json(['error' => "unable get information!"]);
            }
            return Response::json(['speed' => $jsonArray->wind->speed,'Deg' => $jsonArray->wind->deg]);
        }else{
            return Response::json(['error' => "Invalid ZipCode!"]);
        }
    }
}


