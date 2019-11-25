# Weather API

On the page *Weather Prognose API* (weather/api), the REST API will fetch a weather prognose of 30 days past. Every response will be in a JSON format. This API in turn calls on another API, the Dark Sky API.

The input field takes two parameters. First, *json*, is the format type of the response. The second, *latitude,longitude* takes two values, separated by a comma ",". These values, respectively, are the latitude and longitude coordinates. A latitude or longitude is a number with decimals. The number is separated with a dot "." from the decimals. Each coordinate is not limited by the length of decimals, and each coordinate can contain a negative or a positive value.

Pay attention to the placeholder text in the input field. A correct input would be: *json 42.3601,-71.0589*. Also pay attention to the white space between the first parameter "json " and the coordinates, and the comma without white space between the latitude and longitude coordinates as to separate which coordinate is which.

An error message will be returned if the input is not according to the right format.

Mandatory format is: "json 42.3601,-71.0589" without the quotation marks.