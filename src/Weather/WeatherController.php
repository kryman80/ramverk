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
    private $title;


    /**
     * Initializing properties for the controller.
     */
    public function initialize()
    {
        $this->diPage = $this->di->get("page");
        $this->diRequest = $this->di->get("request");
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
        if ($this->diRequest->getGet("weather")) {
            $latLong = $this->diRequest->getGet("weather");

            // if ($latLong)
        }
        $data = [
            // "title" => $this->title,
        ];

        $this->diPage->add("weather/index");

        $greet = $this->di->get("weather");

        return $greet->greet();

        return $this->diPage->render([
            "title" => $this->title,
        ]);
    }
}
