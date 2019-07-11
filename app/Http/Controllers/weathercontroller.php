<?php

namespace App\Http\Controllers;

use GuzzleHttp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class weathercontroller extends Controller
{
    public function weather($zipcode)
    {
        $apiKey = "a14af5a9243a729b10d95b23e577277c";
		$infoList =array();
        $client = new GuzzleHttp\Client();
        $res = $client->get('api.openweathermap.org/data/2.5/weather?zip='.$zipcode.',us&appid='.$apiKey);
        $jsonArray = json_decode($res->getBody());
		return Response::json(['speed' => $jsonArray->wind->speed,'Deg' => $jsonArray->wind->deg]);
    }

    public function weather1($zipcode)
    {
        if($this->isValidZipCode($zipcode)){
            $minutes = 15;
            $info =
                Cache::remember('info', $minutes, function () use ($zipcode){
                    Log::info("Not from cache");
                    $apiKey = config("owm.api_key");
                    $url = "api.openweathermap.org/data/2.5/weather?zip=${zipcode}&appid=${apiKey}";
                    Log::info($url);
                    $client =
                        new \GuzzleHttp\Client();
                    $res = $client->get($url);

                    if ($res->getStatusCode() == 200) {
                        $jsonArray = json_decode($res->getBody());
                    }
                    return Response::json(['speed' => $jsonArray->wind->speed,'Deg' => $jsonArray->wind->deg]);
                });

            return $info;
        }else{
            return Response::json(['error' => "Invalid ZipCode!"]);
        }
    }

    function isValidZipCode($zipCode) {
        return (preg_match('/^[0-9]{5}(-[0-9]{4})?$/', $zipCode)) ? true : false;
    }
}
