<?php

namespace Anax\IPLookup;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

use Anax\Model;

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
     *
     * 2. Test validity and version of IP.
     */
    public function testIndexAction()
    {
        // 1.1 Test without a value.
        $api = null;
        $this->controller->indexAction($api);
        $this->assertEmpty($this->diReq->getGet("ip"));
        // 1.2 Test with any value.
        $api = "value";
        $this->controller->indexAction($api);
        $this->assertIsString($this->diReq->getGet("ip"));
        
        // 2.1 Test version 4.
        $ip4 = "192.199.91.129";
        $this->controller->checkValidIP->checkWhichIP($ip4);
        $this->assertSame("4", $this->controller->checkValidIP->getVersionOfIP());
        // 2.2 Test version 6.
        $ip6 = "2001:0db8:85a3:0000:0000:8a2e:0370:7334";
        $this->controller->checkValidIP->checkWhichIP($ip6);
        $this->assertSame("6", $this->controller->checkValidIP->getVersionOfIP());
        // 2.3 Check IP address validity (IPv6).
        $this->diReq->setGet("ip", $ip6);
        $this->controller->indexAction();
        $this->controller->checkValidIP->checkWhichIP($ip6);
        $this->assertTrue($this->controller->checkValidIP->getValidIPv6());
    }


    /**
     * Testing API action.
     *
     * 1. Testing when landing on page if ipstack API is working.
     * 2. Check correct requests.
     */
    public function testApiAction()
    {
        // 1. Checking ipstack object received value.
        $this->controller->apiAction();
        $ipstackObj = json_decode($this->controller->ipStack->checkIP());
        $this->assertIsObject($ipstackObj);

        // 2.1 Check "ip" request.
        $this->diReq->setGet("ip", "value");
        $this->controller->apiAction();
        //2.2 Check "route" request.
        $this->diReq->setGet("route", "value");
        $this->controller->apiAction();
    }
}
