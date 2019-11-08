<?php
/**
 * Routes for IP validation.
 */
return [
    "routes" => [
        [
            "info" => "IP validator.",
            "mount" => "ip",
            "handler" => "\Anax\IPValidator\IPValidatorController",
        ],
    ],
];
