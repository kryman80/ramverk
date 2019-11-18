<?php

namespace Anax\Model;

use PHPUnit\Framework\TestCase;

/**
 * Test class for IpStackModel.
 */
class IpStackModelTest extends TestCase
{
    private $ipstack;

    
    /**
     * Setting up the test environment.
     */
    protected function setUp()
    {
        $this->ipstack = new IpStackModel();
    }


    /**
     * Testing getSpecificInfoAboutIP() function.
     *
     * Testing different routes.
     *
     * Due to bad coding, misspelled routes is not possible to check.
     * The "resp" object is always a successfull object as long
     * as the IP address is valid.
     */
    public function testGetSpecificInfoAboutIP()
    {
        $ip = "192.71.198.143";

        // 1. Checking object received on route "all".
        $route = "all";
        $this->assertIsObject($this->ipstack->getSpecificInfoAboutIP($ip, $route));

        // 2.1 Route "ip", should return two key pair values, "ip" and "type".
        $route = "ip";
        $ipstackResp = $this->ipstack->getSpecificInfoAboutIP($ip, $route);
        $this->assertArrayHasKey("ip", $ipstackResp);
        $this->assertArrayHasKey("type", $ipstackResp);

        // 2.2 Check IP is the same in the above array.
        $this->assertEquals($ip, $ipstackResp["ip"]);

        // 3 Check route "country".
        $route = "country";
        $ipstackResp = $this->ipstack->getSpecificInfoAboutIP($ip, $route);
        $this->assertArrayHasKey("country", $ipstackResp);

        // Check route "city".
        $route = "city";
        $ipstackResp = $this->ipstack->getSpecificInfoAboutIP($ip, $route);
        $this->assertArrayHasKey("city", $ipstackResp);

        // Check route "latlong".
        $route = "latlong";
        $ipstackResp = $this->ipstack->getSpecificInfoAboutIP($ip, $route);
        $this->assertArrayHasKey("latitude", $ipstackResp);
        $this->assertArrayHasKey("longitude", $ipstackResp);
    }
}
