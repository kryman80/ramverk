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

## Weather API

On the page *Weather Prognose API* (weather/api), the REST API will fetch a weather prognose of 30 days past. Every response will be in a JSON format. This API in turn calls on another API, the Dark Sky API.

The input field takes two parameters. First, *json*, is the format type of the response. The second, *latitude,longitude* takes two values, separated by a comma ",". These values, respectively, are the latitude and longitude coordinates. A latitude or longitude is a number with decimals. The number is separated with a dot "." from the decimals. Each coordinate is not limited by the length of decimals, and each coordinate can contain a negative or a positive value.

Pay attention to the placeholder text in the input field. A correct input would be: *json 42.3601,-71.0589*. Also pay attention to the white space between the first parameter "json " and the coordinates, and the comma without white space between the latitude and longitude coordinates as to separate which coordinate is which.

An error message will be returned if the input is not according to the right format.

Mandatory format is: "json 42.3601,-71.0589" without the quotation marks.