<?php

namespace Anax\Model;

/**
 * Model class for validating IP adresses.
 */
class IPValidationModel
{
    /**
     * @var bool $validIPv4
     * @var bool $validIPv6
     * @var string $versionOfIP
     */
    private $validIPv4;
    private $validIPv6;
    private $versionOfIP;


    /**
     * Constructor.
     *
     * @param string $ipAddress
     */
    public function __construct($ipAddress = null)
    {
        $this->validIPv4 = false;
        $this->validIPv6 = false;
        $this->versionOfIP = null;
        $this->checkWhichIP($ipAddress);
    }


    /**
     * Check version and address of IP.
     *
     * @param string $ipAddress
     *
     * @return bool $ip
     */
    public function checkWhichIP($ipAddress)
    {
        if (is_null($ipAddress)) {
            return;
        }

        $ip = strlen($ipAddress) < 32 ? $this->ipv4($ipAddress) : $this->ipv6($ipAddress);
        
        return $ip;
    }


    /**
     * Check validity of IPv4 address.
     *
     * @param string $ipAddress
     *
     * @return bool $validIPv4
     */
    public function ipv4($ipAddress)
    {
        $this->versionOfIP = "4";

        foreach (explode(".", $ipAddress) as $value) {
            if (strlen($value) > 3) {
                return false;
            }

            $value = (int) $value;
            
            if ($value > 255) {
                return false;
            }
        }

        $this->validIPv4 = preg_match("/^[1-9]+\.\d+\.\d+\.\d+/", $ipAddress) ? true : false;
        
        return $this->validIPv4;
    }

    
    /**
     * Check validity of IPv6 address.
     *
     * @param string $ipAddress
     *
     * @return bool $validIPv6
     */
    public function ipv6($ipAddress)
    {
        $this->versionOfIP = "6";

        $ip6AddressArray = explode(":", $ipAddress);

        if (count($ip6AddressArray) != 8) {
            return false;
        } else {
            foreach ($ip6AddressArray as $value) {
                if (strlen($value) != 4) {
                    return false;
                }
            }
        }

        $ip6P = "[0-9A-Fa-f]";

        $this->validIPv6 = preg_match("/^$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+/", $ipAddress) ? true : false;

        return $this->validIPv6;
    }


    /**
     * Get the value of $validIPv4.
     *
     * @return bool $validIPv4
     */
    public function getValidIPv4()
    {
        return $this->validIPv4;
    }


    /**
     * Get the value of $validIPv6.
     *
     * @return bool $validIPv6
     */
    public function getValidIPv6()
    {
        return $this->validIPv6;
    }


    /**
     * Get the version of IP.
     *
     * @return bool $versionOfIP
     */
    public function getVersionOfIP()
    {
        return $this->versionOfIP;
    }
}
