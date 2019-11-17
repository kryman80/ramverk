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
    }


    /**
     * Testing initialize function.
     */
    public function testInitialize()
    {
        $this->controller->initialize();
    }
}