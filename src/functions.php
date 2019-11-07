<?php

namespace Anax\IPValidator;

function checkWhichIP($ipAddress)
{    
    $ip = strlen($ipAddress) < 32 ? ipv4($ipAddress) : ipv6($ipAddress);

    return $ip;
}

function ipv4($ipAddress)
{    
    foreach (explode(".", $ipAddress) as $value) {
        if (strlen($value) > 3) {
            return false;
        }

        $value = (int) $value;
        
        if ($value > 255) {
            return false;
        }
    }

    return preg_match("/^[1-9]+\.\d+\.\d+\.\d+/", $ipAddress);
}

function ipv6($ipAddress)
{    
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

    return preg_match("/^$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+\:$ip6P+/", $ipAddress);
}