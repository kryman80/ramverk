<?php

namespace Anax\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * Class for the weather API service.
 */
class Weather implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    
    private $isLatLongValidInput;
    private $darkSkyApiUrl = "https://api.darksky.net/forecast/";
    private $darkSkyApiKey;


    public function checkLatLongInput($latLong)
    {
        $latLong = trim($latLong);
        $this->isLatLongValidInput = strpos($latLong, " ") ? false : (
            substr_count($latLong, ",") > 1 ? false : (
                substr_count($latLong, ".") > 2 ? false : true
            )
        );

        if ($this->isLatLongValidInput) {
            $this->checkLatLongWeather($this->isLatLongValidInput);
        } else {
            return $this->isLatLongValidInput;
        }
    }


    public function checkLatLongWeather($latLong)
    {
        // $ch = curl_init()
    }


    public function getDarkSkyApiKey()
    {
        $this->darkSkyApiKey = json_decode(file_get_contents(ANAX_INSTALL_PATH . "/config/api_keys"));

        return $this->darkSkyApiKey;
    }
}
