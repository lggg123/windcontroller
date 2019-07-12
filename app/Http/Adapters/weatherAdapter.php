<?php
namespace App\Http\Adapters;

use App\Http\OWMInfo;
use App\Http\Interfaces\owmInterface;

class weatherAdapter implements owmInterface{
    private $owmInfo;

    public function __construct(OWMInfo $owmInfo)
    {
        $this->owmInfo = $owmInfo;
    }

    public function getInfo($zipcode){
        return $this->owmInfo->getWindInfo($zipcode);
    }
}

