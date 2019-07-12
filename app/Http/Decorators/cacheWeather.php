<?php
use App\Http\Interfaces\owmInterface;
use Illuminate\Contracts\Cache\Repository as Cache;

class cacheWeather implements owmInterface{
    protected $weatherInfo;
    protected $cache;

    public function __construct(owmInterface $weatherInfo, Cache $cache)
    {
        $this->weatherInfo = $weatherInfo;
        $this->cache = $cache;
    }

    public function getInfo($zipcode){
        return $this->cache->tags('weatherInfo')->remember('getInfo', 15, function() use($zipcode){
            return $this->owmInfo->getWindInfo($zipcode);
        });
    }
}