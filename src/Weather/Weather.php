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
        $this->darkSkyApiKey = json_decode(file_get_contents(ANAX_INSTALL_PATH . "/config/api_keys"));
        $this->darkSkyApiUrl = "https://api.darksky.net/forecast/{$this->darkSkyApiKey->dark_sky_api}";
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
            $this->checkLatLongWeather($latLong);
        } else {
            return $this->isLatLongValidInput;
        }
    }


    public function checkLatLongWeather($latLong)
    {
        // var_dump($latLong);
        
        $chSetOptions = [
            CURLOPT_RETURNTRANSFER => true,
        ];
        $url = "{$this->darkSkyApiUrl}/{$latLong}";
        $ch = curl_init($url);
        curl_setopt_array($ch, $chSetOptions);

        $forecastResponse = json_decode(curl_exec($ch), true);
        curl_close($ch);

        // var_dump($res);
        
        $mh = curl_multi_init();
        // $errCode = curl_multi_add_handle($mh, $ch);

        $curlHandlers = [];

        foreach ($forecastResponse as $fr) {
            // $ch = curl_init();
        }

        // if ($errCode == 0) {            
        //     do {
        //         $status = curl_multi_exec($mh, $stillRunning);
        //         if ($stillRunning) {
        //             curl_multi_select($mh);
        //             $chArr[] = curl_multi_getcontent($ch);
        //         }
        //     } while ($stillRunning && $status == CURLM_OK);
            
        //     curl_multi_remove_handle($mh, $ch);
        //     curl_multi_close($mh);
        // }

        // $jArr = [];
        // foreach ($chArr as $c) {
        //     $jArr[] = json_decode($c, true);
        // }
        // foreach ($jArr as $j) {
        //     // var_dump($j[0][0]);
        // }
        // var_dump($jArr);
    }


    public function getDarkSkyApiKey()
    {
        return $this->darkSkyApiKey;
    }
}
