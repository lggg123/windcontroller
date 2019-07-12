<?php
namespace App\Http\Interfaces;

use App\Http\OWMInfo;

interface owmInterface {
    public function getInfo($zipcode);
}