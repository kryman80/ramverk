<?php

namespace Anax\IPValidator;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test class for APIIPValidatorController.
 */
class APIIPValidatorControllerTest extends TestCase
{
    protected $di;
    protected $controller;

    /**
     * Setting up the test environment.
     */
    public function setUp()
    {
        global $di;

        // Setup di.
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use different cache directory for testing.
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses global $di, so it needs its values.
        $di = $this->di;

        // Setup the controller.
        $this->controller = new APIIPValidatorController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }

    /**
     * Testing the initialize method.
     */
    public function testInitialize()
    {
        $this->assertNull($this->controller->initialize());
    }

    /**
     * Testing mount point index(Action).
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        $this->assertContains("<title>Validate an IP via API.", $res->getBody());

        $req = $this->di->get("request");
        // Should pass the condition.
        $ip4ValidApiInputWrongIp = "ip4 99";
        $req->setGet("api_ip-address", $ip4ValidApiInputWrongIp);
        $this->controller->indexAction();

        $this->assertInstanceOf(\Anax\Response\ResponseUtility::class, $res);

        // Should pass the condition.
        $ip6ValidApiInputWrongIp = "ip6 122";
        $req->setGet("api_ip-address", $ip6ValidApiInputWrongIp);
        $this->controller->indexAction();

        // Should return false from the condition.
        $ip6InvalidApiInputCorrectIp = "ip62001:0db8:85a3:0000:0000:8a2e:0370:7334";
        $req->setGet("api_ip-address", $ip6InvalidApiInputCorrectIp);
        $this->controller->indexAction();
    }

    /**
     * Testing mount point json(Action).
     */
    public function testJsonAction()
    {
        $jsonError = json_encode($this->controller->jsonAction());
        $this->assertJsonStringEqualsJsonString(
            json_encode([ [ "error" => "Check your parameters." ] ]),
            $jsonError
        );
        
        // This should not pass due to wrong ip parameter.
        $req = $this->di->get("request");
        $req->setGet("ip5", "192.168.0.1");
        $this->controller->jsonAction();

        // This should pass.
        $req->setGet("ip4", "192.168.0.1");
        $this->controller->jsonAction();
    }
}
