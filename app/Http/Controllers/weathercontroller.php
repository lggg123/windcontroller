<?php

namespace App\Http\Controllers;

use GuzzleHttp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Http\OWMInfo;
use App\Http\Adapters\weatherAdapter;

class weathercontroller extends Controller
{
    public function weather($zipcode)
    {
        $owmInfo = new weatherAdapter(new OWMInfo());
        return $owmInfo->getInfo($zipcode);
    }
}
