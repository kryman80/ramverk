<?php
/**
 * Routes for API IP validation.
 */
return [
    "routes" => [
        [
            "info" => "API IP validator.",
            "mount" => "api",
            "handler" => "\Anax\IPValidator\APIIPValidatorController",
        ],
    ],
];
