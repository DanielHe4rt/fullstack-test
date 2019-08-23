<?php
/**
 * Created by PhpStorm.
 * User: Daniel Reis
 * Date: 23-Aug-19
 * Time: 20:22
 */

namespace App\Services;


class WeatherService
{
    public $uri;

    public $key;

    public function __construct()
    {
        $this->uri = env('WEATHER_BASE_URL');
        $this->key = env('WEATHER_KEY');
    }

    public function getWeatherInformation(string $city, string $state){
        $city = str_replace(' ','%20',$city);
        $uri = $this->uri . "/weather?key={$this->key}&city_name={$city},{$state}";
        return json_decode(file_get_contents($uri));


    }
}
