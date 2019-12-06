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
    private $darkSkyApiUrl;
    private $darkSkyApiKey;


    public function __construct()
    {
        $this->fetchApiKey();

        $this->darkSkyApiUrl = "https://api.darksky.net/forecast/{$this->darkSkyApiKey}";
    }


    public function fetchApiKey()
    {
        $apiFile = json_decode(file_get_contents(ANAX_INSTALL_PATH . "/config/api_keys"));
        $ch = curl_init($apiFile->dark_sky_api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $replaceSubstrings = [
            "{" => "", 
            "}" => "",
            '"' => "",
            "dark_sky_api" => "",
            " " => "",
            ":" => "",
            "\n" => ""
        ];
        $this->darkSkyApiKey = strtr(curl_exec($ch), $replaceSubstrings);        
        curl_close($ch);
    }


    public function checkLatLongInput($latLong)
    {
        $latLong = trim($latLong);
        $this->isLatLongValidInput = strpos($latLong, " ") ? false : (
            substr_count($latLong, ",") > 1 ? false : (
                substr_count($latLong, ".") > 2 ? false : true
            )
        );

        if ($this->isLatLongValidInput) {
            return $this->checkLatLongWeather($latLong);
        } else {
            return $this->isLatLongValidInput;
        }
    }


    public function checkLatLongWeather($latLong)
    {
        $chSetOptions = [
            CURLOPT_RETURNTRANSFER => true,
        ];
        
        $url = "{$this->darkSkyApiUrl}/{$latLong}";
        $curlHandlers = [];
        
        $mh = curl_multi_init();

        for ($i = 1; $i <= 30; $i++) {
            $date = new \DateTime();
            $di = new \DateInterval("P{$i}D");
            $diff = date_sub($date, $di);
            $timestamp = date_timestamp_get($diff);
            
            $ch = curl_init("{$url},{$timestamp}?exclude=currently,minutely,hourly");
            curl_setopt_array($ch, $chSetOptions);
            curl_multi_add_handle($mh, $ch);
            $curlHandlers[] = $ch;
        }
        
        do {
            curl_multi_exec($mh, $stillRunning);
            if ($stillRunning) {
                curl_multi_select($mh);
            }
        } while ($stillRunning);

        $chResponseList = [];
        foreach ($curlHandlers as $ch) {
            $chResponseList[] = json_decode(curl_multi_getcontent($ch), true);
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);

        return $chResponseList;
    }


    public function checkJSONInput($latLong)
    {
        $isJsonStringFound = substr_count($latLong, "json ");
        
        if ($isJsonStringFound) {
            $latLong = str_replace("json ", "", $latLong);
            return $this->checkLatLongInput($latLong);
        } else {
            return $isJsonStringFound;
        }
    }


    public function getDarkSkyApiKey()
    {
        return $this->darkSkyApiKey;
    }


    public function getIsLatLongValidInput()
    {
        return $this->isLatLongValidInput;
    }


    public function setIsLatLongValidInput($value)
    {
        $this->isLatLongValidInput = $value;

        return $this->isLatLongValidInput;
    }
}
