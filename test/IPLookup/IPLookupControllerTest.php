<?php

namespace Anax\IPLookup;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test controller class for the IP lookup controller.
 */
class IPLookupControllerTest extends TestCase
{
    protected $di;
    protected $controller;
    
    /**
     * Set up the test environment before each test.
     */
    protected function setUp()
    {
        global $di;

        // Set up the $di.
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use different cache dir. for testing.
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers use global $di. It needs its values.
        $di = $this->di;

        // Set up controller.
        $this->controller = new IPLookupController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();

        // My own variables.
        $this->diReq = $this->di->get("request");
    }


    /**
     * Testing initialize function.
     *
     * Checking if attribute exists.
     */
    public function testInitialize()
    {
        $IPController = new IPLookupController();
        $this->assertObjectHasAttribute("diPage", $IPController);
    }


    /**
     * Testing index action.
     *
     * 1. Test $api argument has any value when defining it
     * as a parameter in the function definition.
     * When argument has a value, the get request will be set.
     * 1.1 Test without a value.
     * 1.2 Test with any value.
     */
    public function testIndexAction()
    {
        // 1.1
        $api = null;
        $this->controller->indexAction($api);
        $this->assertEmpty($this->diReq->getGet("ip"));
        // 1.2
        $api = "value";
        $this->controller->indexAction($api);
        $this->assertIsString($this->diReq->getGet("ip"));
    }
}