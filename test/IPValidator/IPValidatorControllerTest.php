<?php

namespace Anax\IPValidator;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the IPValidatorController.
 */
class IPValidatorControllerTest extends TestCase
{
    protected $di;
    protected $controller;
    private $diReq;

    /**
     * Set up test environment before each test.
     */
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
        $this->controller = new IPValidatorController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();

        // My own variables.
        $this->diReq = $this->di->get("request");
    }

    /**
     * Testing initialize method.
     */
    public function testInitialize()
    {
        $this->assertNull($this->controller->initialize());
    }

    /**
     * Test index mountpoint.
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        
        $this->assertInstanceOf(\Anax\Response\ResponseUtility::class, $res);
        $this->assertContains("IP validering", $res->getBody());
        
        $this->diReq->setGet("ip-address", "255");
        $this->controller->indexAction();
    }
}
