# REST API

## How to use the API

It is mandatory to specify the internet protocol with a whitespace before the address. Follow the formats below:

* ip4 192.168.0.1
* ip6 2001:0db8:85a3:0000:0000:8a2e:0370:7334

Pay attention to the longer format of IPv6. It could be that an external API like ipstack might accept the shorter format.

## Response

The result will be printed in JSON.

## Valid/invalid IP address

If the address is entered without the API (prefix) key (e.g. ip4), the page will reload. If an invalid IP address follows a correct API key, the result including the IP will output either false or null values in the JSON response.

A correct IP address prefixed with an API key results in a successfull JSON object. However, pay attention to, a valid IP address is quite different from a true IP address (an IP address that exists). The same valid IP address that does not exist will result only in an output of the IP address but the rest of the fields might be null values.