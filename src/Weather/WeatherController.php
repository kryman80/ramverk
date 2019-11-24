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
        // $a = json_decode(json_encode($chResponse));
        // var_dump($a);
        // foreach ($chResponse as $key => $val) {
        //     var_dump($val["daily"]["data"][0]["time"]);
        // }        
        $data = [
            "isInputValid" => $this->diWeather->getIsLatLongValidInput(),
            "latLong" => $this->latLong,
            "chResponse" => $chResponse,
        ];

        $this->diPage->add("weather/index", $data);
        

        return $this->diPage->render([
            "title" => $this->title,
        ]);
    }
}
