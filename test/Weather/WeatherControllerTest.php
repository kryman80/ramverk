<?php

namespace Anax\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Testing the Weather controller.
 */
class WeatherControllerTest extends TestCase
{
    protected $di;
    protected $diReq;
    protected $controller;

    protected function setUp()
    {
        global $di;

        // Setup di.
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use different cache directory for testing.
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di, so it needs its value.
        $di = $this->di;

        // Setup the controller.
        $this->controller = new WeatherController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();

        // My own variables.
        $this->diReq = $this->di->get("request");
        $this->diRes = $this->di->get("response");
    }

    
    public function testInitialize()
    {
        $this->assertNull($this->controller->initialize());
    }


    /**
     * Test index action.
     *
     * 1. Test input.
     */
    public function testIndexAction()
    {
        // 1.1 Wrong input with too many commas.
        $this->diReq->setGet("weather", "12.33,,23.45");
        $this->controller->indexAction();
        $body = $this->diRes->getBody();
        $this->assertContains("The format is wrong! 12.33,,23.45", $body);

        // 1.2 Wrong empty input.
        $this->diReq->setGet("weather", "");
        $this->controller->indexAction();
        $body = $this->diRes->getBody();
        $this->assertContains("The format is wrong! Empty string.", $body);
    }


    /**
     * Test api action.
     *
     * 1. Test response from input.
     */
    public function testApiAction()
    {
        // 1.1 Test response back is JSON from correct input.
        $this->diReq->setGet("weather-api", "json 42.3601,-71.0589");
        $this->controller->apiAction();
        $getInput = $this->diReq->getGet("weather-api");
        $this->diRes->sendJson($getInput);
        $headers = $this->diRes->getHeaders();
        $this->assertArraySubset(["Content-Type: application/json; charset=utf8"], $headers);

        // 1.2 Test if body response is correct
        // error message presented from wrong input.
        $this->diReq->setGet("weather-api", "");
        $this->controller->apiAction();
        $getInput = $this->diReq->getGet("weather-api");
        $body = $this->diRes->getBody();
        $this->assertContains("Empty input.", $body);

        // 1.3 Test invalid input.
        $this->diReq->setGet("weather-api", "13.9876,24.7654");
        $this->controller->apiAction();
        $getInput = $this->diReq->getGet("weather-api");
        $checkInputStartsWithJSON = strpos($getInput, "json");
        $this->assertFalse($checkInputStartsWithJSON);

        // 1.4 Test API key is the same as in API URL.
        $this->diReq->setGet("weather-api", "json 42.3601,-71.0589");
        $this->controller->apiAction();
        $apiKey = json_decode(file_get_contents(ANAX_INSTALL_PATH . "/config/api_keys"));
        $weather = $this->di->get("weather");
        $weatherApiKey = $weather->getDarkSkyApiKey();
        $this->assertStringContainsString($apiKey->dark_sky_api, $weatherApiKey);
    }
}
