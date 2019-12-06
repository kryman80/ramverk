<?php
/**
 * Route for the weather API, (Dark Sky API).
 */
return [
    "routes" => [
        [
            "info" => "Dark Sky API",
            "mount" => "weather",
            "handler" => "\Anax\Weather\WeatherController"
        ],
    ],
];
