<?php

namespace Anax\IPValidator;

use PHPUnit\Framework\TestCase;

/**
 * Test the functions.php file.
 */
class FunctionsTest extends TestCase
{
    /**
     * Testing correct/erroneous ip addresses.
     */
    public function testCheckWhichIP()
    {
        $ip4Address = "127.0.0.1";
        $ip4WrongAddress = "127.0.0.256";
        $ip4WrongAddressTooManyDigits = "127.1234.0.1";
        
        $ip6Address = "2001:0db8:85a3:0000:0000:8a2e:0370:7334";
        $ip6WrongAddressTooFewSequences = "2001:0db8:85a3:0000:0000:8a2e:7334";
        $ip6WrongAddressTooManyDigits = "2001:0db8:85a30:0000:0000:8a2e:0370:7334";

        $ip = checkWhichIP($ip4Address);
        $this->assertTrue(true);
        print($ip);
        
        $ip = checkWhichIP($ip4WrongAddress);
        $this->assertFalse(false);
        print($ip);

        $ip = checkWhichIP($ip4WrongAddressTooManyDigits);
        $this->assertFalse(false);
        print($ip);

        $ip = checkWhichIP($ip6Address);
        $this->assertTrue(true);
        print($ip);

        $ip = checkWhichIP($ip6WrongAddressTooFewSequences);
        $this->assertFalse(false);
        print($ip);

        $ip = checkWhichIP($ip6WrongAddressTooManyDigits);
        $this->assertFalse(false);
        print($ip);
    }
}
