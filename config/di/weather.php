<?php

/**
 * Configuration file for the weather API as a $di service.
 */
return [
    // Services to add to the container.
    "services" => [
        "weather" => [
            "shared" => true,
            "callback" => function () {
                $weather = new \Anax\Weather\Weather();
                $weather->setDI($this);
                return $weather;
            }
        ],
    ],
];
