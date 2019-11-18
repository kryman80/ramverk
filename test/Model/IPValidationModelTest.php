<?php

namespace Anax\Model;

use PHPUnit\Framework\TestCase;

/**
 * Testing IPValidationModel class.
 */
class IPValidationModelTest extends TestCase
{
    private $ipValModel;

    
    /**
     * Setting up the test suite.
     */
    protected function setUp()
    {
        $this->ipValModel = new IPValidationModel();
    }


    /**
     * Testing function ipv4().
     *
     * 1. Testing any sequence above three digits.
     * 2. Testing IP range above 255.
     */
    public function testIpv4()
    {
        // 1. Sequence longer than 3 digits.
        $ip = "125.255.2343.1";
        $validIP = $this->ipValModel->ipv4($ip);
        $this->assertFalse($validIP);

        // 2. IP address range greater than 255.
        $ip = "255.200.100.256";
        $this->assertFalse($this->ipValModel->ipv4($ip));
    }


    /**
     * Testing function ipv6().
     *
     * 1. Testing series not more than 8.
     * 2. Testing sequence not more than four hexadecimals.
     */
    public function testIpv6()
    {
        // 1.
        $ip = "2000:abcd:eeee:ffff:efef:0000:0001:7777:8811";
        $this->assertFalse($this->ipValModel->ipv6($ip));

        // 2.
        $ip = "10aa:4411:3333:cfge:5555:badb:7a234:0011";
        $this->assertFalse($this->ipValModel->ipv6($ip));
    }
}
