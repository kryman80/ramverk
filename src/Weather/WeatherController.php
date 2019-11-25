<?php

namespace Anax\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * Controller class for the (Dark Sky) Weather API.
 */
class WeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @vars
     */
    private $diPage;
    private $diRequest;
    private $diWeather;
    private $latLong;
    private $title;


    /**
     * Initializing properties for the controller.
     */
    public function initialize()
    {
        $this->diPage = $this->di->get("page");
        $this->diRequest = $this->di->get("request");
        $this->diWeather = $this->di->get("weather");
        $this->latLong = null;
        $this->title = "Looking up weather prognoses";
    }


    /**
     * Mount points:
     * / -- index.php
     *
     * @return Response $di
     */
    public function indexAction()
    {
        $isLatLongValid = null;
        $chResponse = null;

        if ($this->diRequest->getGet("weather")) {
            $this->latLong = $this->diRequest->getGet("weather");

            $chResponse = $this->diWeather->checkLatLongInput($this->latLong);
        }
        
        $data = [
            "isInputValid" => $this->diWeather->getIsLatLongValidInput(),
            "latLong" => $this->latLong,
            "chResponse" => $chResponse,
            "latitude" => $chResponse[0]["latitude"],
            "longitude" => $chResponse[0]["longitude"],
        ];

        $this->diPage->add("weather/index", $data);
        
        return $this->diPage->render([
            "title" => $this->title,
        ]);
    }


    public function apiAction()
    {
        $invalidInput = false;
        $latLongInput = null;
        
        if ($this->diRequest->getGet("weather-api")) {
            $latLongInput = $this->diRequest->getGet("weather-api");
            $respFromInput = $this->diWeather->checkJSONInput($latLongInput);

            if ($respFromInput) {
                return [[ $respFromInput ]];
            }            
            $invalidInput = true;            
        } else if ($this->diRequest->getGet("weather-api") === "") {
            $invalidInput = true;
            $latLongInput = "Empty input.";
        }

        $data = [
            "invalidInput" => $invalidInput,
            "input" => $latLongInput,
        ];

        $this->diPage->add("weather/api", $data);

        return $this->diPage->render([
            "title" => "Rest API getting the weather prognose",
        ]);
    }
}
