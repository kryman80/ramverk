<?php

/**
 * Configuration file for the weather API as a $di service.
 */
return [
    // Services to add to the container.
    "services" => [
        "weather" => [
            "shared" => true,
            // "callback" => "\Anax\Weather\Weather"
            "callback" => function () {
                $weather = new \Anax\Weather\Weather();
                // $weather = new \Anax\Model\IPValidationModel();
                // $weather->setDI($this);
                return $weather;
            }
        ],
    ],
];
